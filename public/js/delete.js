const deleteModal1 = document.getElementById('deleteModal1');
if(deleteModal1) {
    deleteModal1.addEventListener('show.bs.modal', event => {
    
        const button = event.relatedTarget;
        
        const articolId = button.getAttribute('data-bs-whatever');
        
        const modalInputId = document.getElementById('inputId');
    
        modalInputId.value = articolId;
    
    });
}


const deleteReplyModal = document.getElementById('deleteReplyModal');
if(deleteReplyModal) {
    deleteReplyModal.addEventListener('show.bs.modal', event => {
    
        const button = event.relatedTarget;
        
        const replyId = button.getAttribute('data-bs-replyId');
        const articolId = button.getAttribute('data-bs-articolId');
        const commentId = button.getAttribute('data-bs-commentId');
        const recipient = button.getAttribute('data-bs-recipient');
        const user_id = button.getAttribute('data-bs-user');
        
        const modalInputReplyId = document.getElementById('reply_id');
        const modalInputArticolId = document.getElementById('delete2_articol_id');
        const modalInputCommentId = document.getElementById('delete2_comment_id');
        const modalInputRecipient = document.getElementById('delete2_recipient');
        const modalInputUserId = document.getElementById('delete2_user_id');

        modalInputReplyId.value = replyId;
        modalInputArticolId.value = articolId;
        modalInputCommentId.value = commentId;
        modalInputRecipient.value = recipient;
        modalInputUserId.value = user_id;

    });
}

const deleteCommentModal = document.getElementById('deleteCommentModal');
if(deleteCommentModal) {
    deleteCommentModal.addEventListener('show.bs.modal', event => {
    
        const button = event.relatedTarget;
        
        const commentId = button.getAttribute('data-bs-commentId');
        const articolId = button.getAttribute('data-bs-articolId');
        
        const modalInputCommentId = document.getElementById('delete1_comment_id');
        const modalInputArticolId = document.getElementById('delete1_articol_id');

        modalInputCommentId.value = commentId;
        modalInputArticolId.value = articolId;

    });
}

