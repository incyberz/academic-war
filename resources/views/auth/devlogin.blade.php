<div class="debug p-2 mt-3">
  <style>
    .btn_login_as {
      border: solid 1px #ccc;
      border-radius: 5px;
      padding: 5px;
      margin-bottom: 5px;
      background: darkblue;
    }

    .btn_login_as:hover {
      background: blue;
    }
  </style>
  <div>DevLogin As:</div>
  <button class="btn_login_as" id='ahmad@gmail.com--ahmad'>Mhs</button>
  <button class="btn_login_as" id='iin@gmail.com--iin'>Dosen Iin</button>
  <button class="btn_login_as" id='topan--topan'>Dosen Topan</button>
  <button class="btn_login_as" id='yulis@gmail.com--yulis'>Akademik</button>
  <button class="btn_login_as" id='insho@gmail.com--insho'>SuperAdmin</button>

  <script>
    $(function(){
                    $('.btn_login_as').click(function(){
                        let tmp = this.id.split('--');
                        let username = tmp[0];
                        let password = tmp[1];
                        console.log(username,password);
                        $('#login').val(username);
                        $('#password').val(password);
                        $('#btn_login').click();

                    })
                })
  </script>
</div>