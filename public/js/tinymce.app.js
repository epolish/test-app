var url = window.location.protocol + '//' + window.location.hostname + '/';
tinymce.init({
  selector : "textarea",
  document_base_url : url,
  plugins : ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste jbimages"],
  toolbar : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",
});