function addcustomerpayterm1(){
  var customername = $("#customername").val();
    // getplaceofsupply();
  if(customername===""){

  }
  else{
    $.ajax({
        type: "POST",
        url: "../src/fetchaddressinfobyid.php",
        data:{
          custid:parseInt(customername)
        },
        success: function(msg) {

           var response = JSON.parse(msg);
           $("#phidecontactid").val(response['contactId']);
           $("#pbillingaddress").val(response['contactAddress']);
        }
    });
  }
}
function addcustomerpayterm(){
  var customername = $("#customername").val();
  if(customername==="#ac"){
    // alert("modalopen");
    $('#CustomerModal').modal('show');
    $("#customername").val("");
  }
  else{
    // alert("modalelse");
    addcustomerpayterm1();
  }
}

function getpaymethodmethod()
{
var payterm='';
  payterm+='<select  class="form-control" data-provide="selectpicker" data-live-search="true"  title="Choose a terms" onchange="addpaymentmethod()" id="paymentmethod">';
    $.ajax({
        type: "POST",
        url: "../src/fetch_paymentmethod.php",
        success: function(msg) {


          payterm+=msg;
          payterm+='<option data-icon="fa fa-edit" style="font-weight: bold;  padding: 5px;color: #797878;border: 2px solid #71bd71;"  value="apm" >Add Payment Method</option>';
          payterm+='<option value=""></option>';
          payterm+='</select>';
          $("#setpaymentmethod").html(payterm);
        }
    });
}
function getdepositeto()
{
var payterm='';
  payterm+='<select  class="form-control" data-provide="selectpicker" data-live-search="true"  title="Choose a Deposit to" id="paymentdepositeto">';
    $.ajax({
        type: "POST",
        url: "../src/fetch_depositeto.php",
        success: function(msg) {
          // alert(msg);

          payterm+=msg;
          // payterm+='<option data-icon="fa fa-edit" style="font-weight: bold;  padding: 5px;color: #797878;border: 2px solid #71bd71;"  value="apm" >Add Payment Method</option>';
          payterm+='<option value=""></option>';
          payterm+='</select>';
          $("#setdepositeto").html(payterm);
        }
    });
}

function addpaymentmethod()
{
  var paymentmethod = $("#paymentmethod").val();

  if(paymentmethod==='apm'){
     $('#PaymentModal').modal('show');
     $("#paymentmethod").val("");
  }
}


function addpaymethod(){
  var paymentmethod  = $("#paymentmethodval").val();
   // alert(paymentmethod);
  if(paymentmethod === ""){
      $('#paymentmethod').focus();
  }
  else {
    $.ajax({
      url:'../src/addNewPaymentmethod.php',
      type:'POST',
      data:({paymentmethod:paymentmethod}),
      dataType:'json',
      success:function(response){
        // alert(response);
        if(response['msg']){
          $('#PaymentModal').modal('hide');
          var param1 = "Payment Method "+response['paytype']+" Added successfully";
          app.toast(param1, {
            actionTitle: 'Success',
            // actionUrl: 'something',
            actionColor: 'success'
          });
          clear_paymentmethod();
          getpaymethodmethod();
        }

      }
    })
  }
}

function DisplayPaymentTblData(){
    $("#paymentTblBody").empty();
  // var TotalRevenue = 0.00;
   var  tbl = '';
    tbl += '<tr>';
    tbl += '<td>1</td>';
    tbl += '<td>Invoice # 1014(20/02/2019)</td>';

    tbl += '<td>DUE DATE</td>';
    tbl += '<td>ORIGINAL AMOUNT</td>';
    tbl += '<td>OPEN BALANCE</td>';
    tbl += '<td>PAYMENT</td>';
    tbl += '<td>ACTION</td>';
    tbl += '</tr>';
    tbl += '<tr>';
    tbl += '<td>1</td>';
    tbl += '<td>Invoice # 1014(20/02/2019)</td>';

    tbl += '<td>DUE DATE</td>';
    tbl += '<td>ORIGINAL AMOUNT</td>';
    tbl += '<td>OPEN BALANCE</td>';
    tbl += '<td>PAYMENT</td>';
    tbl += '<td>ACTION</td>';
    tbl += '</tr>';
    tbl += '<tr>';
    tbl += '<td>1</td>';
    tbl += '<td>Invoice # 1014(20/02/2019)</td>';

    tbl += '<td>DUE DATE</td>';
    tbl += '<td>ORIGINAL AMOUNT</td>';
    tbl += '<td>OPEN BALANCE</td>';
    tbl += '<td>PAYMENT</td>';
    tbl += '<td>ACTION</td>';
    tbl += '</tr>';
    tbl += '<tr>';
    tbl += '<td>1</td>';
    tbl += '<td>Invoice # 1014(20/02/2019)</td>';

    tbl += '<td>DUE DATE</td>';
    tbl += '<td>ORIGINAL AMOUNT</td>';
    tbl += '<td>OPEN BALANCE</td>';
    tbl += '<td>PAYMENT</td>';
    tbl += '<td>ACTION</td>';
    tbl += '</tr>';
    // $.ajax({
    //         url:"../src/displayInvoice.php",
    //         type:"POST",
    //         dataType:"json",
    //         success:function(response){
    //           var count = response.length;
    //           for (var i = 0; i < count; i++) {
    //             $("#paymentTblBody").append('<tr><th scope="row">'+(i + 1)+'</th><td>'
    //             +response[i].InvoiceNumber+'</td><td>'
    //             +response[i].name+'</td><td>'
    //             +response[i].DateCreated+'</td><td>'
    //             +response[i].DueDate+'</td><td>'
    //             +response[i].Balance+'</td><td>'
    //             +response[i].Total+'</td><td>'
    //             +response[i].status+
    //             '</td><td><button class=" btn-link dropdown-toggle" type="button" data-toggle="dropdown">Edit</button><div class="dropdown-menu"><a class="dropdown-item" href="#" onclick="PrintInvoice('+response[i].TId+')">Print</a><a class="dropdown-item" href="#modal-invoice"  data-formid="1" data-formtype="U" data-transactionid="'+response[i].TId+'"  data-toggle="modal">Edit</a><a class="dropdown-item" href="#" onclick="EditInvoice('+response[i].TId+')">View</a><a class="dropdown-item" href="#" onclick="DeleteInvoice('+response[i].TId+')">Delete</a></div></td></tr>');
    //
    //           }
    //
    //
    //           }
    //         });
    alert(tbl);
     $("#paymentTblBody").html(tbl);
            $('#paymentTbl').DataTable({
              searching: true,
              retrieve: true,
              bPaginate: $('tbody tr').length>10,
              order: [],
              columnDefs: [ { orderable: false, targets: [0,1,2,3,4,5,6] } ],
              dom: 'Bfrtip',

              destroy: true
            });
}
function clear_paymentmethod()
{
$("#paymentmethod").val('');

}
