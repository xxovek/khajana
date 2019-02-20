$('#TaxData').on('submit',function(e){
    e.preventDefault();
    var TaxType  = document.getElementById('TaxType').value;
    var TaxPercent  = document.getElementById('TaxPercent').value;
  if(TaxType == ""){
      $('#TaxType').focus();
  }else if(TaxPercent==""){
      $('#TaxPercent').focus();
  }
  else {
    $.ajax({
      url:'../src/AddNewTax.php',
      type:'POST',
      data:({TaxType:TaxType,TaxPercent:TaxPercent}),
      dataType:'json',
      success:function(response){
        $('#TaxModal .close').click();
        sptax();
        app.toast(response.msg, {
          actionTitle: 'Success',
          // actionUrl: 'something',
          actionColor: 'success',
          duration: 4000
        });
      }
    })
  }
});
function additemtax(){
  var TaxType  = document.getElementById('TaxType').value;
  var TaxPercent  = document.getElementById('TaxPercent').value;
  var hiddenitemtax =$("#hiddenitemtax").val();

  if(TaxType == ""){
      $('#TaxType').focus();
  }
  else if(TaxPercent==""){
      $('#TaxPercent').focus();
  }
  else {
    $.ajax({
      url:'../src/AddNewTax.php',
      type:'POST',
      data:({TaxType:TaxType,TaxPercent:TaxPercent}),
      dataType:'json',
      success:function(response){
        $('#TaxModal').modal('hide');
         connectitemtax(hiddenitemtax);
      }
    })
  }
}

function checktaxaval(){
var TaxPercent  = parseFloat($('#TaxPercent').val());
// alert(TaxPercent);
if((TaxPercent>0.01) && (TaxPercent<100)){
    $("#taxavl").html("");
    $.ajax({
      url:'../src/fetchavltax.php',
      type:'POST',
      data:({TaxPercent:TaxPercent}),
      dataType:'json',
      success:function(response){
        if(response['count']>0){
            $("#taxavl").html("<font color='red'>Tax value is already exists</font>");
            $('#TaxPercent').val("");
        }
        else {
          $("#taxavl").html("");
        }
      }
    });
}
else
{
  $("#taxavl").html("<font color='red'>Tax value must be greater than 0.01 and less than 100</font>");
  $('#TaxPercent').val("");
}
}
