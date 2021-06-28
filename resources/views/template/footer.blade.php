   
</section>

<!-- move top -->
<button onclick="topFunction()" id="movetop" class="bg-primary" title="Go to top">
  <span class="fa fa-angle-up"></span>
</button>

<script>
  // When the user scrolls down 20px from the top of the document, show the button
  window.onscroll = function () {
    scrollFunction()
  };

  function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      document.getElementById("movetop").style.display = "block";
    } else {
      document.getElementById("movetop").style.display = "none";
    }
  }

  // When the user clicks on the button, scroll to the top of the document
  function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
  }
</script>
<!-- /move top -->


<script src="{{ asset ('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset ('js/jquery-1.10.2.min.js') }}"></script>

<!-- chart js -->
<script src="{{ asset ('js/Chart.min.js') }}"></script>
<script src="{{ asset ('js/utils.js') }}"></script>
<!-- //chart js -->

<!-- Different scripts of charts.  Ex.Barchart, Linechart -->
<script src="{{ asset ('js/bar.js') }}"></script>
<script src="{{ asset ('js/linechart.js') }}"></script>
<!-- //Different scripts of charts.  Ex.Barchart, Linechart -->


<script src="{{ asset ('js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset ('js/scripts.js') }}"></script>

<!-- close script -->
<script>
  var closebtns = document.getElementsByClassName("close-grid");
  var i;

  for (i = 0; i < closebtns.length; i++) {
    closebtns[i].addEventListener("click", function () {
      this.parentElement.style.display = 'none';
    });
  }
</script>
<!-- //close script -->

<!-- disable body scroll when navbar is in active -->
<script>
  $(function () {
    $('.sidebar-menu-collapsed').click(function () {
      $('body').toggleClass('noscroll');
    })
  });
</script>
<!-- disable body scroll when navbar is in active -->

 <!-- loading-gif Js -->
 <script src="{{ asset ('js/modernizr.js') }}"></script>
 <script>
     $(window).load(function () {
         // Animate loader off screen
         $(".se-pre-con").fadeOut("slow");;
     });
 </script>
 <!--// loading-gif Js -->

<!---moment js-->
<script src="{{ asset('js/moment.min.js') }}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ asset ('js/bootstrap.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script> 



<!-- Employee,Department,and Student Datatable,update,and delete JS -->
<script src="{{ asset('js/main.js') }}"></script>

<!-- Employee Attendance and Report JS -->
<script src="{{ asset('js/attendance.js') }}"></script>


<!-- Show Password JS -->
<script>
    function showPassword() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
    }
    function showBothPassword() {
    var x = document.getElementById("password");
    var y = document.getElementById("password_confirmation");
    if (x.type === "password" && y.type === "password") {
        x.type = "text";
        y.type = "text";
    } else {
        x.type = "password";
        y.type = "password";
    }
    }

</script>

<!-- Timesheet JS -->
<script src="{{ asset('js/timesheet.js') }}"></script>

<!-- Location JS -->
<script src="{{ asset('js/location.js') }}"></script>

<!-- chat JS -->
<script src="{{ asset('js/chat.js') }}"></script>

<script src="{{ asset('js/userchat.js') }}"></script>

<script>
  function edit(id)
  {
    $.ajax({
          type:"POST",
          url: "/ipaddress/edit",
          data: { id: id },
          dataType: 'json',
          success: function(response){
              console.log(response);
              $('#editIpModal').modal('show');
              $('#ipId').val(response.id);
              $('#ipAddress').val(response.ipaddress);
              $('#userId').val(response.user_id);
              $('#emailId').val(response.user_id);
          }
      });
  }

  $('#ipAddressForm').submit(function(){
      var id = $('#ipId').val();
      var userId = $('#userId').val();
      var ipAddress = $('#ipAddress').val();
      $.ajax({
          type:'POST',
          url: "/ipaddress/update",
          dataType: 'json',
          data: {id:id,userId:userId,ipAddress:ipAddress},
          success: function(response){
              console.log(response);
              $('#editIpModal').modal('hide');
              window.location.reload();
          }
      });
  });
</script>

<script src='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.js'></script>

<script src="{{ asset('js/main.js') }}" ></script>




<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>

<script src="{{ asset('js/app.js') }}" defer></script>
@livewireScripts

<script src="https://cdn.jsdelivr.net/gh/livewire/vue@v0.3.x/dist/livewire-vue.js"></script>

</body>

</html>