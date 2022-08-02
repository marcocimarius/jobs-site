const exampleModal = document.getElementById('exampleModal');
if(exampleModal) {
    exampleModal.addEventListener('show.bs.modal', event => {
        
        const button = event.relatedTarget;
        
        const commentId = button.getAttribute('data-bs-whatever');
        const commentUser = button.getAttribute('data-bs-author');
        const commentContent = button.getAttribute('data-bs-content');
        const recipient_id = button.getAttribute('data-bs-recipient_id');
        
        const modalTitle = exampleModal.querySelector('.modal-title');
        const modalInputId = document.getElementById('comment_id');
        const modalInputAuthor = document.getElementById('recipient-name');
        const modalInputContent = document.getElementById('previousTextarea');
        const recipientLoginToDB = document.getElementById('recipientLoginToDB');
        const recipientId = document.getElementById('recipient_id');

        modalTitle.textContent = `Reply to ${commentUser}`;
        modalInputId.value = commentId;
        modalInputAuthor.value = commentUser;
        modalInputContent.value = commentContent;
        recipientLoginToDB.value = commentUser;
        recipientId.value = recipient_id;
    });
}


const exampleModal2 = document.getElementById('exampleModal2');
if(exampleModal2) {
    exampleModal2.addEventListener('show.bs.modal', event => {
    
        const button = event.relatedTarget;
        
        const commentId = button.getAttribute('data-bs-whatever');
        const replyUser = button.getAttribute('data-bs-author');
        const replyContent = button.getAttribute('data-bs-content');
        const recipient_id = button.getAttribute('data-bs-recipient_id');
        const main_reply_id = button.getAttribute('data-bs-main_reply_id');
    
        const modalTitle = exampleModal2.querySelector('.modal-title');
        const modalInputId = document.getElementById('commentId');
        const modalInputAuthor = document.getElementById('recipient-name2');
        const modalInputContent = document.getElementById('previousTextarea2');
        const inputRecipientToDB = document.getElementById('nameToDB');
        const recipientId = document.getElementById('recipient_id2');
        const main_reply_id_input = document.getElementById('main_reply_id2');
    
        modalTitle.textContent = `Reply to ${replyUser}`;
        modalInputId.value = commentId;
        modalInputAuthor.value = replyUser;
        modalInputContent.value = replyContent;
        inputRecipientToDB.value = replyUser;
        recipientId.value = recipient_id;
        main_reply_id_input.value = main_reply_id;
    });
};

