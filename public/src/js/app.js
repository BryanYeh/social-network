var postId = 0;
postBodyElement = null;

$('.edit-link').on('click', function(event){
   event.preventDefault();
   postBodyElement = event.target.parentNode.parentNode.childNodes[1];
   var postBody = postBodyElement.textContent;
   postId = event.target.parentNode.parentNode.dataset['postid'];
   $('#post-body').val(postBody);
   $('#edit-modal').modal();
});

$('#modal-save').on('click', function(){
   $.ajax({
      method: 'POST',
      url: urlEdit,
      data: { body: $('#post-body').val(), postId: postId, _token: token}
   })
   .done(function(msg){
      $(postBodyElement).text(msg['new-body']);
      $('#edit-modal').modal('hide');
   });
});

$('.like').on('click', function(event){
   event.preventDefault();
   postId = event.target.parentNode.parentNode.dataset['postid'];
   var isLike = event.target.previousElementSibling == null;
   $.ajax({
      method: 'POST',
      url: urlLike,
      data: {isLike: isLike, postId: postId, _token: token}
   })
   .done(function(){

   });
});
