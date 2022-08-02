const adminModal = document.getElementById('adminModal');
if(adminModal) {
    adminModal.addEventListener('show.bs.modal', event => {
    
        const button = event.relatedTarget;
        
        const user_id = button.getAttribute('data-bs-whatever');
        const username = button.getAttribute('data-bs-username');
        
        const modalInputId = document.getElementById('utilizator_id');
        const modalTitle = document.getElementById('adminModalLabel');
        const question = document.getElementById('question');

        modalInputId.value = user_id;
        modalTitle.textContent = `Make ${username} administrator`;
        question.textContent = `Are you sure you want to make ${username} an administrator?`;
    });
}

const followModal = document.getElementById('followModal');
if(followModal) {
    followModal.addEventListener('show.bs.modal', event=> {
        const button = event.relatedTarget;

        const followedId = button.getAttribute('data-bs-followedId');
        const subscriberId = button.getAttribute('data-bs-subscriberId');
        const login = button.getAttribute('data-bs-login');

        const modalInputFollowedId = document.getElementById('followed_id');
        const modalInputSubscriberId = document.getElementById('subscriber_id');
        const modalTitle = document.getElementById('followModalLabel');
        const question = document.getElementById('followQuestion');

        modalInputFollowedId.value = followedId;
        modalInputSubscriberId.value = subscriberId;
        modalTitle.textContent = `Follow ${login}`;
        question.textContent = `By following ${login} you will receive notifications everytime this user creates a post.`;
    });
}

const unfollowModal = document.getElementById('unfollowModal');
if(unfollowModal) {
    unfollowModal.addEventListener('show.bs.modal', event=> {
        const button = event.relatedTarget;

        const followedId = button.getAttribute('data-bs-followedId');
        const subscriberId = button.getAttribute('data-bs-subscriberId');
        const login = button.getAttribute('data-bs-login');

        const modalInputFollowedId = document.getElementById('unfollowed_id');
        const modalInputSubscriberId = document.getElementById('unsubscriber_id');
        const modalTitle = document.getElementById('unfollowModalLabel');
        const question = document.getElementById('unfollowQuestion');

        modalInputFollowedId.value = followedId;
        modalInputSubscriberId.value = subscriberId;
        modalTitle.textContent = `Unfollow ${login}`;
        question.textContent = `By unfollowing ${login} you will no longer receive notifications everytime this user creates a post`;
    });
}

const banModal = document.getElementById('banModal');
if(banModal) {
    banModal.addEventListener('show.bs.modal', event=> {
        const button = event.relatedTarget;

        const bannedUserId = button.getAttribute('data-bs-userBanned');
        const commentId = button.getAttribute('data-bs-commentId');
        const articolId = button.getAttribute('data-bs-articolId');
        const commentAuthor = button.getAttribute('data-bs-comment_author');

        const userInput = document.getElementById('banned_user_id');
        const commentInput = document.getElementById('banned_comment_id');
        const articolInput = document.getElementById('banned_from_post_id');
        const authorInput = document.getElementById('banned_comment_author');

        userInput.value = bannedUserId;
        commentInput.value = commentId;
        articolInput.value = articolId;
        authorInput.value = commentAuthor;
    });
}

const banModall = document.getElementById('banModall');
if(banModall) {
    banModal.addEventListener('show.bs.modal', event => {
    
        const button = event.relatedTarget;
        
        const postId = button.getAttribute('data-bs-whatever');
        const userId = button.getAttribute('data-bs-user');
        const author = button.getAttribute('data-bs-author');
        
        const modalInputPostId = document.getElementById('banned_from_post_id');
        const modalInputUserId = document.getElementById('banned_user_id');
        const modalInputAuthor = document.getElementById('banned_author');

        modalInputPostId.value = postId;
        modalInputUserId.value = userId;
        modalInputAuthor.value = author;

    });
}

const banUserModal = document.getElementById('banUserModal');
if(banUserModal) {
    banUserModal.addEventListener('show.bs.modal', event => {
    
        const button = event.relatedTarget;
        
        const postId = button.getAttribute('data-bs-whatever');
        const userId = button.getAttribute('data-bs-user');
        const author = button.getAttribute('data-bs-author');
        
        const modalInputPostId = document.getElementById('bannedd_from_post_id');
        const modalInputUserId = document.getElementById('bannedd_user_id');
        const modalInputAuthor = document.getElementById('bannedd_comment_author');

        modalInputPostId.value = postId;
        modalInputUserId.value = userId;
        modalInputAuthor.value = author;
    });
}

const banModal2 = document.getElementById('banModal2');
if(banModal2) {
    banModal2.addEventListener('show.bs.modal', event=> {
        const button = event.relatedTarget;

        const bannedUserId = button.getAttribute('data-bs-userBanned');
        const commentId = button.getAttribute('data-bs-commentId');
        const articolId = button.getAttribute('data-bs-articolId');
        const commentAuthor = button.getAttribute('data-bs-comment_author');

        const userInput = document.getElementById('banneed_user_id');
        const commentInput = document.getElementById('banneed_comment_id');
        const articolInput = document.getElementById('banneed_from_post_id');
        const authorInput = document.getElementById('banneed_comment_author');

        userInput.value = bannedUserId;
        commentInput.value = commentId;
        articolInput.value = articolId;
        authorInput.value = commentAuthor;
    });
}

