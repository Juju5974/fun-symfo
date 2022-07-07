console.log("Hello Light !");

const btnModal = document.getElementsByClassName("callModal");
const formPost = document.getElementById("form_post");
/* Ajouter un listener à chacun des boutons */
for(let i = 0 ; i < btnModal.length; i++) {
    btnModal[i].addEventListener('click', callModal);
}

function callModal(e) {
postID = e.target.dataset.post;
formPost.value = postID;
}