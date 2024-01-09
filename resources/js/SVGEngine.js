const svg = document.getElementById('schema');

// Fonction pour créer une liaison entre deux points
function creerLien(pointDepart, pointArrivee) {
    const lien = document.createElementNS('http://www.w3.org/2000/svg', 'line');
    lien.setAttribute('x1', pointDepart.getAttribute('transform').match(/\(([^)]+)\)/)[1].split(',')[0]);
    lien.setAttribute('y1', pointDepart.getAttribute('transform').match(/\(([^)]+)\)/)[1].split(',')[1]);
    lien.setAttribute('x2', pointArrivee.getAttribute('transform').match(/\(([^)]+)\)/)[1].split(',')[0]);
    lien.setAttribute('y2', pointArrivee.getAttribute('transform').match(/\(([^)]+)\)/)[1].split(',')[1]);
    lien.setAttribute('stroke', '#fbbf24');
    svg.insertBefore(lien, svg.firstChild);
    return lien;
}

function createNode(angle, rayon, refx, refy, imageSrc, texte) {
    const x = refx + rayon * Math.cos(angle);
    const y = refy + rayon * Math.sin(angle);

    const group =
        document.createElementNS('http://www.w3.org/2000/svg', 'g');
    group.setAttribute('transform', `translate(${x}, ${y})`)

    const favIcon = document.createElementNS('http://www.w3.org/2000/svg',
        'image');
    favIcon.setAttribute('x', -10);
    favIcon.setAttribute('y', -10);
    favIcon.setAttribute('width', 20);
    favIcon.setAttribute('height', 20);
    favIcon.setAttribute('href', imageSrc);
    group.appendChild(favIcon);

    const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
    text.setAttribute('y', 25);
    text.setAttribute('fill', 'white')
    text.setAttribute('text-anchor', 'middle');
    text.textContent = texte;
    group.appendChild(text);

    return group;
}

function compterElements(targets) {
    let nombreTotal = 0;
    for (const domaine in targets) {
        if (targets.hasOwnProperty(domaine)) {
            nombreTotal += 1//targets[domaine].length;
        }
    }
    return nombreTotal;
}

const points = [];
const root = createNode(0, 0,
    (svg.getBoundingClientRect().width/2), (svg.getBoundingClientRect().height/2),
    'http://www.google.com/s2/favicons?domain=' + source, source);
points.push(root);
svg.appendChild(root);

function BuildChildNode(nodes, ref) {
    var actuelCount = 0;
    const rayon = 250;
    const countTargets = compterElements(nodes);

    for (const target in nodes) {

        const angle = (actuelCount * 2 * Math.PI) / countTargets;
        const imageSrc = 'http://www.google.com/s2/favicons?domain=' + target; // Lien du FavIcon
        const refBounding = ref.getBoundingClientRect()
        const node = createNode(
            angle, rayon, ref.transform.baseVal[0].matrix.e, ref.transform.baseVal[0].matrix.f , imageSrc, target);

        points.push(node);
        svg.appendChild(node);

        // Lier chaque point au point de départ (le premier point)
        creerLien(ref, node);

        actuelCount += 1;
    }
}

BuildChildNode(targets, root);


// ZOOm
let isDragging = false;
let dragStartX, dragStartY;
let viewBox = { x: 0, y: 0, width: svg.width.baseVal.value, height: svg.height.baseVal.value };
let zoomLevel = 1;

function handleWheel(event) {
    event.preventDefault();

    const mouseX = event.clientX - svg.getBoundingClientRect().left;
    const mouseY = event.clientY - svg.getBoundingClientRect().top;

    const factor = event.deltaY < 0 ? 1.2 : 1 / 1.2;

    // Ajuster le point d'origine de la vue en fonction de la position de la souris
    viewBox.x -= (mouseX - viewBox.x) * (factor - 1);
    viewBox.y -= (mouseY - viewBox.y) * (factor - 1);

    zoomLevel *= factor;

    updateViewBox();
}

function updateViewBox() {
    const newWidth = svg.width.baseVal.value / zoomLevel;
    const newHeight = svg.height.baseVal.value / zoomLevel;

    viewBox.width = newWidth;
    viewBox.height = newHeight;

    svg.setAttribute('viewBox', `${viewBox.x} ${viewBox.y} ${newWidth} ${newHeight}`);
}

function handleMouseDown(event) {
    isDragging = true;
    dragStartX = event.clientX;
    dragStartY = event.clientY;
}

function handleMouseMove(event) {
    if (isDragging) {
        const deltaX = event.clientX - dragStartX;
        const deltaY = event.clientY - dragStartY;

        viewBox.x -= deltaX / zoomLevel;
        viewBox.y -= deltaY / zoomLevel;

        svg.setAttribute('viewBox', `${viewBox.x} ${viewBox.y} ${viewBox.width} ${viewBox.height}`);

        dragStartX = event.clientX;
        dragStartY = event.clientY;
    }
}

function handleMouseUp() {
    isDragging = false;
}

svg.addEventListener('wheel', handleWheel);
svg.addEventListener('mousedown', handleMouseDown);
svg.addEventListener('mousemove', handleMouseMove);
svg.addEventListener('mouseup', handleMouseUp);
svg.addEventListener('mouseleave', handleMouseUp);
