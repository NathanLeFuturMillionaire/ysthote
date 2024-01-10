    // Sélection de l'élément input de type fichier
    const input = document.getElementById('profil-picture');

    // Sélection de l'élément label
    const label = document.querySelector('label[for="profil-picture"]');
    
    // Ajout d'un écouteur d'événement pour détecter les changements dans l'élément input
    input.addEventListener('change', function() {
        const file = this.files[0]; // Récupération du fichier sélectionné
    
        if (file) {
            const reader = new FileReader(); // Création d'un objet FileReader
    
            // Fonction exécutée lorsque le contenu du fichier est lu avec succès
            reader.onload = function(e) {
                const imgSrc = e.target.result; // Récupération de l'URL de l'image
    
                // Modification de l'attribut src de l'image dans le label pour afficher l'image sélectionnée
                label.querySelector('img').setAttribute('src', imgSrc);
            }
    
            reader.readAsDataURL(file); // Lecture du contenu du fichier en tant qu'URL de données
        }
    });
    