(function() {
    function getUrlParameter(name) {
        var url = new URL(window.location.href);
        return url.searchParams.get(name);
    }

    var width = getUrlParameter('width') || '250';
    var height = getUrlParameter('height') || '250';
    var position = getUrlParameter('position') || 'top';
    var key = getUrlParameter('key');

    width = isNaN(width) ? 300 : parseInt(width);
    height = isNaN(height) ? 250 : parseInt(height);

    const validPositions = ['top', 'bottom', 'left', 'right'];
    if (!validPositions.includes(position)) {
        position = 'top'; 
    }

    var bannerContainer = document.createElement('div');
    bannerContainer.style.width = width + 'px';
    bannerContainer.style.height = height + 'px';
    bannerContainer.style.position = 'fixed';
    bannerContainer.style[position] = '0';
    bannerContainer.style.left = '0';
    bannerContainer.style.zIndex = '9999';
    bannerContainer.style.display = 'none'; 

    fetch('http://127.0.0.1:8000/api/banner?key='+key)
        .then(response => response.json())
        .then(data => {
            if (data && data.imageUrl && data.link) {
                var bannerLink = document.createElement('a');
                bannerLink.href = data.link;
                bannerLink.target = '_blank';

                var bannerImage = document.createElement('img');
                bannerImage.src = data.imageUrl;
                bannerImage.alt = data.alt_text || 'Banner Image';
                bannerImage.style.width = '100%';
                bannerImage.style.height = '100%';

                bannerLink.appendChild(bannerImage);
                bannerContainer.appendChild(bannerLink);

                document.body.appendChild(bannerContainer);

                bannerContainer.style.display = 'block';
            } else {
                console.error('Invalid banner data received from the API');
                bannerContainer.innerHTML = '<p>Banner is not available.</p>';
                document.body.appendChild(bannerContainer);
                bannerContainer.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error loading banner:', error);
            bannerContainer.innerHTML = '<p>Failed to load the banner.</p>';
            document.body.appendChild(bannerContainer);
            bannerContainer.style.display = 'block';
        });
})();
