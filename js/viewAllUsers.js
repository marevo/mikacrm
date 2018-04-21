/**
 * Created by marevo on 27.09.2017.
 */
$('#tbViewAllUsers').on('click','button',function (event) {
    var target = event.target;
    if (target.nodeName == 'SPAN')
        target = target.parentNode;
    if(target.name == 'btnEditModalUser'){
        console.log('будем править user');
        var idUser = $(target).data('id');
        if(idUser){
            $tbOldNewDataUser = $('#tbModalDataUser');
            $trWhereWasClick = $(target).parent().parent();
            $tbOldNewDataUser.find('[data-id]').textContent = idUser;
            $tbOldNewDataUser.find('[data-name]').next().find('input').value = $trWhereWasClick[1].textContent;
            $tbOldNewDataUser.find('[data-login]').next().find('input').value = $trWhereWasClick[2].textContent;
            $tbOldNewDataUser.find('[data-password]').next().find('input').value = $trWhereWasClick[3].textContent;
            $tbOldNewDataUser.find('[data-mail]').next().find('input').value = $trWhereWasClick[4].textContent;
            $tbOldNewDataUser.find('[data-question]').next().find('input').value = $trWhereWasClick[5].textContent;
            $tbOldNewDataUser.find('[data-answer]').next().find('input').value = $trWhereWasClick[6].textContent;
            $tbOldNewDataUser.find('[data-answer]').next().find('input').value = $trWhereWasClick[6].textContent;
            $('#modalWinForDeleteUser').modal('hide');
            $('#modalViewUpdateUser').modal('show');
        }
    }
    if(target.name == 'btnDeleteModalUser'){
        console.log('будем удалять user');
        var idUser = $(target).data('id');
        if(idUser){
            $('#modalViewUpdateUser').modal('hide');
            $('#modalWinForDeleteUser').modal('show');
        }
    }

    return false;
});