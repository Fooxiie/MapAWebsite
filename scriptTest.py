import requests
from bs4 import BeautifulSoup
import tldextract
from urllib.parse import urlparse, urljoin

def get_external_dependencies(url, max_depth=2):
    external_dependencies = set()

    def get_domain(url):
        return urlparse(url).hostname

    def crawl_page(current_url, depth):
        if depth > max_depth:
            return
        
        space = ""
        for i in range(depth):
            space += "    "

        try:
            response = requests.get(current_url)
            if response.status_code == 200:
                soup = BeautifulSoup(response.text, 'html.parser')
                for tag in soup.find_all(['link', 'script', 'img', 'iframe', 'style'], src=True):
                    dep_url = urljoin(current_url, tag['src'])
                    if urlparse(dep_url).netloc != urlparse(url).netloc:
                        external_dependencies.add(space + get_domain(dep_url))
                        crawl_page(dep_url, depth + 1)
                for tag in soup.find_all(['link', 'script'], href=True):
                    dep_url = urljoin(current_url, tag['href'])
                    if urlparse(dep_url).netloc != urlparse(url).netloc:
                        external_dependencies.add(space + get_domain(dep_url))
                        crawl_page(dep_url, depth + 1)
                for tag in soup.find_all('a', href=True):
                    dep_url = urljoin(current_url, tag['href'])
                    if urlparse(dep_url).netloc != urlparse(url).netloc:
                        external_dependencies.add(space + get_domain(dep_url))
                        crawl_page(dep_url, depth + 1)
        except Exception as e:
            print(f"Error fetching {current_url}: {str(e)}")

    crawl_page(url, 0)

    return external_dependencies

if __name__ == "__main__":
    start_url = "https://docs.djangoproject.com/"  # Remplacez par l'URL de départ
    external_dependencies = get_external_dependencies(start_url, 1)
    
    print("External domain dependencies:")
    for dep in external_dependencies:
        print(dep)
