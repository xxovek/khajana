displaySchemes();

$("#schemes").on("submit",function(e){
  // alert("o")
  var sId= $("#sid").val();
  var from= $("#fromDate").val();
  var upto= $("#toDate").val();
  var scheme=$("#scheme").val();
  var item=$("#item").val();
  var onpurchase=$("#onpurchase").val();
  var freeqty=$("#freeqty").val();
  // alert(sId+scheme+from+upto+item+onpurchase+freeqty);
  e.preventDefault();

  $.ajax({
            url:"../src/schemes.php",
            method:"POST",
            dataType:'json',
            data:{sId:sId,scheme:scheme,from:from,upto:upto,item:item,onpurchase:onpurchase,freeqty:freeqty},
            success:function(response){
              alert(response.msg);
              window.location.reload();
            }
    });
});
function openScheme() {
$("#schemeTable").hide();
$("#newschemes").show();
}

function displaySchemes(){
  $('#tblData tbody').empty();
var tblData = '';
$.ajax({
  type:'GET',
  url:'../src/fetchAllSchemes.php',
  dataType:'json',
  success:function(response){
    // alert(response);
    var count = Object.keys(response).length;
      if(count > 0){
        for(var i=0;i<count;i++){
            $('#tblDatabody').append('<tr><td class="text-center">'+(i + 1)+'</td><td>'
            +response[i].schemeType+'</td><td>'
            +response[i].Item+'</td><td>'
            +response[i].FromDate+'</td><td>'
            +response[i].UptoDate+'</td><td>'
            +response[i].OnPurchase+'</td><td>'
            +response[i].freeQty+
            '</td><td class="text-center"><button class="btn-link dropdown-toggle" type="button" data-toggle="dropdown">Edit</button><div class="dropdown-menu"><a class="dropdown-item" href="#" onclick="editSchemes(\''+response[i].SchemeId+'\',\''+response[i].schemeType+'\',\''+response[i].FromDate+'\',\''+response[i].UptoDate+'\',\''+response[i].Itemid+'\',\''+response[i].OnPurchase+'\',\''+response[i].freeQty+'\')">View/Edit</a><a class="dropdown-item" href="#" onclick="removeSchemes('+response[i].SchemeId+')" >Delete</a></div></td></tr>');
          }
      }

      $('#tblData').DataTable({
        searching: true,
        retrieve: true,
        bPaginate: $('tbody tr').length>10,
        order: [],
        columnDefs: [ { orderable: false, targets: [0,1,2,3,4,5] } ],
        dom: 'Bfrtip',
        buttons: ['copy','csv', 'excel', 'pdf'],
        destroy: true
      });
  }
});
}
function editSchemes(sId,sName,from,upto,Item,onpurchase,qty){
$("#schemeTable").hide();
$("#newschemes").show();
$("#item").val(Item).trigger('change');
$("#scheme").val(sName);
$("#fromDate").val(from);
$("#toDate").val(upto);
$("#onpurchase").val(onpurchase);
$("#freeqty").val(qty);
$("#sid").val(sId);
}
function removeSchemes(sId){
// alert(TaxId);
var r = confirm('Are You sure To Remove This Tax Parmanetly');
if(r === true){
  $.ajax({
    type:'DELETE',
    url:'../src/removeScheme.php',
    data:{sId:sId},
    dataType:'json',
    success:function(response){
      app.toast(response.msg, {
        actionTitle: 'Success',
        // actionUrl: 'something',
        actionColor: 'success',
        duration: 4000
      });
      displaySchemes();
    }
  });
}


}
