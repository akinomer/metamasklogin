<?php include('vt.php'); 
    
    if($_GET['tip']=='getParity'){
      $getParity = $db->customQuery('Select parity From bnbusd Order By id Desc Limit 1')->getRow();
      echo $getParity->parity;
      exit;
    }

?>
<html>
  <title>MetaMask login</title>

  <head>
      <script src='js/jquery.min.js'></script>
      <script src='js/human_standard_token_abi.js'></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/web3/1.6.1-rc.3/web3.min.js" integrity="sha512-0KTZZdA9E3vaLClQkC6S9roiHr9J2A79Q/BvcIwd8LjRVAQcwrT1zorS7hfZ7B3Nr/u6bYzNG/wXOAOADdJ7qQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  </head>

  <body>
    <h1>MetaMask login</h1>
    <?php $birimfiyat_usd = 0.03; ?>
    <div class="container">
      <div class="row">
        <div id="content" class="col-md-7">
          <button id="login_btn" onclick="login()">login with metamask</button>
        </div>
        <div class="col-md-5">
          <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22286%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20286%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_17d1f90ca05%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A14pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_17d1f90ca05%22%3E%3Crect%20width%3D%22286%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2299.4296875%22%20y%3D%2296.3421875%22%3EImage%20cap%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Satilik urun</h5>
              <p class="card-text">soyle satilik boyle satilik ozellikleri falan</p>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <div class="row">
                  <div class="col-md-4">
                    <span>Qty</span>
                  </div>
                  <div class="col-md-8">
                    <span>Price</span>
                  </div>
                  <div class="col-md-5">
                    <input type="number" id="adet" onchange="fiyatUpdate()" onkeyup="fiyatUpdate()" class="form-control" value="1">
                  </div>
                  <div class="col-md-7">
                    <input type="number" id="unitprice" class="form-control" value="<?=$birimfiyat_usd?>">
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <span class="fiyat"><?=$birimfiyat_usd?></span>
                <span class="curr"><small>USD</small></span>
              </li>
              <li class="list-group-item">
                <p class="card-text">Satin almak istediginiz kuru seciniz</p>
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                  <input type="radio" class="btn-check" name="btnradio" deger='BNB' id="btnradio1" autocomplete="off">
                  <label class="btn btn-outline-primary" for="btnradio1">BNB</label>
                  <input type="radio" class="btn-check" name="btnradio" deger='USD' id="btnradio3" autocomplete="off" checked>
                  <label class="btn btn-outline-primary" for="btnradio3">USD</label>
                  <input type="text" id="bnbvalue">
                </div>
              </li>
            </ul>
            <div class="card-body">
              <button id="gonderbtn" class="form-control btn btn-outline-primary">Satin al</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>

    



      function fiyatUpdate(){
        var toplam = 0;
        var curr = $('[name="btnradio"]:checked').attr('deger');
        if(curr=='USD'){
          toplam = parseFloat($('#adet').val()) * <?=$birimfiyat_usd?>;
          $('.fiyat').html(toplam.toFixed(2));
          $.get("index.php?tip=getParity", function(data, status){
            var usdVal = parseFloat($('#adet').val()) * <?=$birimfiyat_usd?>;
            //console.log(usdVal);
            var parity = JSON.parse(data);
            //console.log(parity['USD']);
            //toplam = usdVal / parity['USD'];
            $('#bnbvalue').val(usdVal / parity['USD']);
          });
        }else{
          $.get("index.php?tip=getParity", function(data, status){
            var usdVal = parseFloat($('#adet').val()) * <?=$birimfiyat_usd?>;
            //console.log(usdVal);
            var parity = JSON.parse(data);
            //console.log(parity['USD']);
            toplam = usdVal / parity['USD'];
            //console.log(toplam);
            $('.fiyat').html(toplam);
            $('#bnbvalue').val(toplam);
          });
        }
        $('.curr small').html(curr)
      }
      
      $('[name="btnradio"]').click(function(){
          var toplam = 0;
          var curr = $('[name="btnradio"]:checked').attr('deger');
          if(curr=='USD'){
            toplam = parseFloat($('#adet').val()) * <?=$birimfiyat_usd?>;
            $('.fiyat').html(toplam.toFixed(2));
          }else{
            $.get("index.php?tip=getParity", function(data, status){
              var usdVal = parseFloat($('#adet').val()) * <?=$birimfiyat_usd?>;
              //console.log(usdVal);
              var parity = JSON.parse(data);
              //console.log(parity['USD']);
              toplam = usdVal / parity['USD'];
              //console.log(toplam);
              $('.fiyat').html(toplam);
            });
          }
          $('.curr small').html(curr)
      });

      async function login() {
        // Modern dapp browsers...
        if (window.ethereum) {
          console.log(" Modern dapp browsers ");
          window.web3 = new Web3(ethereum);
          try {
            // Request account access if needed
            await ethereum.enable();
            console.log(" Acccounts now exposed ");
            // Acccounts now exposed
            doAction();
          } catch (error) {
            console.log(error);
            // User denied account access...
          }
        }
        // Legacy dapp browsers...
        else if (window.web3) {
          console.log(" Legacy dapp browsers ");
          window.web3 = new Web3(web3.currentProvider);
          // Acccounts always exposed
          console.log(" Acccounts always exposed ");
          doAction();
        }
        // Non-dapp browsers...
        else {
          console.log(
            "Non-Ethereum browser detected. You should consider trying MetaMask!"
          );
        }
      }

      var accountAddress = "";
      window.addEventListener('load', async () => {

        if (window.ethereum) {
          window.web3 = new Web3(ethereum);
          
          var accounts = web3.eth.getAccounts((error, result) => {
            if (error) {
              console.log(error);
            } else {
                res = result;
                if(result==''){
                  $('#content').html('<button id="login_btn" onclick="login()">login with metamask</button>');
                }else{
                  accountAddress = result[0];
                  $('#content').html('Your wallet ID is '+result[0]);
                  $('#balance').show();
                }
                //console.log(result[0]);
                web3.eth.getBalance(result[0], function(err, result) {
                if (err) {
                  console.log(err)
                } else {
                  $('#content').append('<br>'+web3.utils.fromWei(result, "ether") + " BNB");
                }
              })

            }
          });
        }
      });
     
      document.getElementById("gonderbtn").onclick = function () {
          //console.log(accountAddress);
          var curr = $('[name="btnradio"]:checked').attr('deger');
          var toplam = 0;
          var deger = 0;
          if(curr=='USD'){
            deger = web3.utils.toWei($('.fiyat').html().toString(),'tether')
          }else{
            var desimal = $('#bnbvalue').val().toString().split('.')[1].length;
            toplam = parseFloat($('#bnbvalue').val()) * (10**(18));
            deger = toplam.toString(16);
          }
          
          
          ethereum.request({
            method: 'eth_sendTransaction',
            params: [
              {
                from: accountAddress,
                to: '0x9f99c341AB3E685836b5EBFBA49fD91F1C17B0F6',
                value: deger
              },
            ],
          })
          .then((txHash) => console.log(txHash))
          .catch((error) => console.error);
      };

      function doAction() {
        console.log("doAction.. ");
        console.log(web3);
        var accounts = web3.eth.getAccounts((error, result) => {
          if (error) {
            console.log(error);
          } else {
            console.log(accounts);
            console.log(result);
          }
        });
      }
    </script>
  </body>
</html>
