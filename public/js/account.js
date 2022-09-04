const bioModal = document.getElementById('bioModal');
if(bioModal) {
    bioModal.addEventListener('show.bs.modal', event=> {
        const button = event.relatedTarget;

        const userId = button.getAttribute('data-bs-whatever');
        const content = button.getAttribute('data-bs-content');

        const modalBioInputId = document.getElementById('bioInputId');
        const modalTitle = document.getElementById('bioModalLabel');
        const bioTextarea = document.getElementById('bioTextarea');

        modalBioInputId.value = userId;
        modalTitle.textContent = "Add bio";
        bioTextarea.value = content;
    });
}

const changePhotoModal = document.getElementById('changePhotoModal');
if(changePhotoModal) {
    changePhotoModal.addEventListener('show.bs.modal', event=> {
        const button = event.relatedTarget;

        const userId = button.getAttribute('data-bs-whatever');

        const changePhotoInputId = document.getElementById('changePhotoInputId');
        const modalTitle = document.getElementById('changePhotoModalLabel');

        changePhotoInputId.value = userId;
        modalTitle.textContent = "Change profile picture";
    });
}