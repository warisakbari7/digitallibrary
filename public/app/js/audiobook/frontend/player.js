$(document).ready(() => {
    let player = document.getElementById('player');

    $('#playerModal').on('hidden.bs.modal', e => {
        player.pause();
        player.currentTime = 0;
    })

    player.oncanplay = () => {
        $('#viewbtn').text('Listen').removeAttr('disabled')
    }
    player.onerror = () => {
        alert("Some Error Occured Please Refresh the Page!");
    }
})