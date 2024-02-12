$(document).ready(function(){
    // Check admin password is correct or not
    $("#current_pwd").keyup(function(){
        var current_pwd = $("#current_pwd").val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:BaseadminUrl + '/' +'check_current_password',
            data:{current_pwd:current_pwd},
            success:function(resp){
                if(resp == "false"){
                    $("#vefiryCurrentPwd").html("Old Password is Incorrect !");
                }else if(resp == "true"){
                    $("#vefiryCurrentPwd").html("Old Password is correct !");
                }
            },error:function(){
                alert('Error');
            }
        })
    });

    /* --- Common Delete Function for all the modules */
    // $(document).on('click', ".confirmDelete", function(){
    //     var record = $(this).attr('record');
    //     var record_id = $(this).attr('record_id');
    //     alert(record);
    //     alert(record_id);
    //     Swal.fire({
    //      title: 'Are you sure?',
    //      text: "You won't be able to revert this!",
    //      icon: 'warning',
    //      showCancelButton: true,
    //      confirmButtonColor: '#3085d6',
    //      cancelButtonColor: '#d33',
    //      confirmButtonText: 'Yes, delete it!'
    //      }).then((result) => {
    //      if (result.isConfirmed) {
    //          Swal.fire(
    //          'Deleted!',
    //          'Your file has been deleted.',
    //          'success'
    //          )
    //          root = "{{ config('app.url') }}"
    //          window.location.href = root + "admin/"+record+"/"+record_id;
    //      }
    //      });

    // });
});
