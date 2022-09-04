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
        const isBanned = button.getAttribute('data-bs-isBanned');        
        const banDate = button.getAttribute('data-bs-banDate');        


        const modalTitle = exampleModal2.querySelector('.modal-title');
        const modalInputId = document.getElementById('commentId');
        const modalInputAuthor = document.getElementById('recipient-name2');
        const modalInputContent = document.getElementById('previousTextarea2');
        const inputRecipientToDB = document.getElementById('nameToDB');
        const recipientId = document.getElementById('recipient_id2');
        const main_reply_id_input = document.getElementById('main_reply_id2');
        const contentTextarea = document.getElementById('contentTextarea');
        
        console.log(isBanned);

        if (isBanned == 0) {
            contentTextarea.textContent = `You have been banned and can't post anything until ${banDate}`;
        }

        modalTitle.textContent = `Reply to ${replyUser}`;
        modalInputId.value = commentId;
        modalInputAuthor.value = replyUser;
        modalInputContent.value = replyContent;
        inputRecipientToDB.value = replyUser;
        recipientId.value = recipient_id;
        main_reply_id_input.value = main_reply_id;
    });
};

const changePhotoModal = document.getElementById('changePhotoModal');
if(changePhotoModal) {
    changePhotoModal.addEventListener('show.bs.modal', event => {
        
        const button = event.relatedTarget;
        
        const post_id = button.getAttribute('data-bs-whatever');

        const modalTitle = document.getElementById('changePhotoModalLabel');
        const modalInputId = document.getElementById('changePhotoInputId');

        modalTitle.textContent = "Change post photo";
        modalInputId.value = post_id;
    });
}

const editReplyModal = document.getElementById('editReplyModal');
if(editReplyModal) {
    editReplyModal.addEventListener('show.bs.modal', event => {
        
        const button = event.relatedTarget;
        
        const reply_id = button.getAttribute('data-bs-whatever');
        const post_id = button.getAttribute('data-bs-post_id');
        const content = button.getAttribute('data-bs-content');

        const modalInputId = document.getElementById('edit_reply_id');
        const modalInputPostId = document.getElementById('edit_post_id');
        const modalInputContent = document.getElementById('edit_reply_content');

        modalInputId.value = reply_id;
        modalInputPostId.value = post_id;
        modalInputContent.textContent = `${content}`;
    });
}

const editCommentModal = document.getElementById('editCommentModal');
if(editCommentModal) {
    editCommentModal.addEventListener('show.bs.modal', event => {
        
        const button = event.relatedTarget;
        
        const comment_id = button.getAttribute('data-bs-whatever');
        const post_id = button.getAttribute('data-bs-post_id');
        const content = button.getAttribute('data-bs-content');

        const modalInputCommentId = document.getElementById('edit_comment_id');
        const modalInputPostId = document.getElementById('edit_comment_post_id');
        const modalInputContent = document.getElementById('edit_comment_content');

        modalInputCommentId.value = comment_id;
        modalInputPostId.value = post_id;
        modalInputContent.textContent = `${content}`;
    });
}