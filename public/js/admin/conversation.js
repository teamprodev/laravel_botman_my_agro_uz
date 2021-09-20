var objDiv = document.querySelector(".msger-chat");
objDiv.scrollTop = objDiv.scrollHeight;
$(document).ready(function () {

    $("input[type='radio']").click(function () {
        var sim = $("input[type='radio']:checked").val();
        //alert(sim);
        if (sim < 3) {
            $('.myratings').css('color', 'red');
            $(".myratings").text(sim);
        } else {
            $('.myratings').css('color', 'green');
            $(".myratings").text(sim);
        }
    });
});

function askClose() {
    Swal.fire({
        title: 'Do you want to close the ?',
        icon: 'question',
        showCancelButton: true,
        denyButtonText: 'Yes',
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            Rate()
        }
    })

}

function Rate() {
    let x = document.querySelector("#submit")
    x.style.display = "block"
    Swal.fire({
        title: '<strong>Expertni baholang</strong>',
        icon: 'info',
        html:x,
          
        showCloseButton: true,
        showCancelButton: true,
        
        focusConfirm: false,
        
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
           x.submit()
            
        }
        x.style.display = "none"
    })
}
