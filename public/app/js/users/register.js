$(document).ready(function() {
    $("#image").change(function(d) {

        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = e => {
                $('#user_img').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0])
        } else {
            $('#user_img').attr('src', img);
        }
    })
});