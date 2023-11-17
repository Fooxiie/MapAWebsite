import requests
from bs4 import BeautifulSoup
from urllib.parse import urlparse, urljoin
from concurrent.futures import ThreadPoolExecutor
from ThirdParty import ThirdParty


class Analyse:
    def __init__(self, hostname) -> None:
        self.host = hostname

    def start_analyse(self, deep=1):
        return self.__get_external_dependencies(self.host, deep)

    def __get_external_dependencies(self, url, max_depth=2):
        external_dependencies = set()

        def get_domain(url):
            return urlparse(url).hostname

        def fetch_page(current_url):
            try:
                response = requests.get(current_url)
                if response.status_code == 200:
                    soup = BeautifulSoup(response.text, "html.parser")
                    deps = set()
                    for tag in soup.find_all(
                        ["link", "script", "img", "iframe", "style"], src=True
                    ):
                        dep_url = urljoin(current_url, tag["src"])
                        hostname = get_domain(dep_url)

                        # Check if there's already a ThirdParty object with the same hostname and source
                        existing_dep = None
                        for dep in deps:
                            if dep.hostname == hostname and dep.source == current_url:
                                existing_dep = dep
                                break

                        # Add the new ThirdParty object if it doesn't exist, or update the existing one
                        if existing_dep is None:
                            deps.add(ThirdParty(hostname, current_url, []))

                    return deps
            except Exception as e:
                print(f"Error fetching {current_url}: {str(e)}")

        def crawl_page(current_url, depth):
            if depth > max_depth:
                return set()
            with ThreadPoolExecutor(max_workers=10) as executor:
                futures = [executor.submit(fetch_page, current_url)]
                for future in futures:
                    deps = future.result()
                    if deps:
                        external_dependencies.update(deps)
                        for dep_url in deps:
                            crawl_page(
                                urljoin(current_url, dep_url.hostname), depth + 1
                            )

        crawl_page(url, 0)

        return external_dependencies
