$.ajaxSetup({
     headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
});

function ConvertDateToThai(data){
     var date = '';
     if (data) {
          var month;
          var x = data.split("-");
          var position_3 = x[0];
          var position_2 = x[1];
          var position_1 = x[2];

          switch (position_2) {
               case '01' : month = "ม.ค."; break;
               case '02' : month = "ก.พ."; break;
               case '03' : month = "มี.ค."; break;
               case '04' : month = "เม.ย."; break;
               case '05' : month = "พ.ค."; break;
               case '06' : month = "มิ.ย."; break;
               case '07' : month = "ก.ค."; break;
               case '08' : month = "ส.ค."; break;
               case '09' : month = "ก.ย."; break;
               case '10' : month = "ต.ค."; break;
               case '11' : month = "พ.ย."; break;
               case '12' : month = "ธ.ค."; break;
               default : '';
          }
          date = position_1 + ' ' + month + ' ' + position_3;
     }
     return date;
}

// function ConvertDateToThai(data){
//      var date = '';
//      if (data) {
//           var month;
//           var x = data.split("-");
//           var position_3 = x[0];
//           var position_2 = x[1];
//           var position_1 = x[2];
//
//           switch (position_2) {
//                case '01' : month = "มกราคม"; break;
//                case '02' : month = "กุมภาพันธ์"; break;
//                case '03' : month = "มีนาคม"; break;
//                case '04' : month = "เมษายน"; break;
//                case '05' : month = "พฤษภาคม"; break;
//                case '06' : month = "มิถุนายน"; break;
//                case '07' : month = "กรกฏาคม"; break;
//                case '08' : month = "สิงหาคม"; break;
//                case '09' : month = "กันยายน"; break;
//                case '10' : month = "ตุลาคม"; break;
//                case '11' : month = "พฤศจิกายน"; break;
//                case '12' : month = "ธันวาคม"; break;
//                default : '';
//           }
//           date = position_1 + ' ' + month + ' ' + position_3;
//      }
//      return date;
// }

function addNumformat(nStr){
     nStr += '';
     x = nStr.split('.');
     x1 = x[0];
     x2 = x.length > 1 ? '.' + x[1] : '';
     var rgx = /(\d+)(\d{3})/;
     while (rgx.test(x1)) {
          x1 = x1.replace(rgx, '$1' + ',' + '$2');
     }
     return x1 + x2;
}

function deleteNumformat(nStr){
     var spl = nStr.split(",");
     var x = "";
     for(i in spl){
          x =x+spl[i];
     }
     return x;
}

function removePriceFormat(form,data){
     var data_return = {};
     $.each(data,function(){
          if($(form).find('[name="'+this.name+'"]').hasClass('price')){
               data_return[this.name] = deleteNumformat(this.value);
          }else{
               data_return[this.name] = this.value;
          }
     });
     return data_return;
}

$('body').on('keydown','.number-only',function (e) {
     // Allow: backspace, delete, tab, escape, enter and .
     if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
     // Allow: Ctrl+A, Command+A
     (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
     // Allow: home, end, left, right, down, up
     (e.keyCode >= 35 && e.keyCode <= 40)) {
          // let it happen, don't do anything
          return;
     }
     // Ensure that it is a number and stop the keypress
     if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
          e.preventDefault();
     }
});
if($(".form_date").length>0){
     $(".form_date").datetimepicker({
          autoclose: true,
          todayBtn: true,
          format: 'yyyy-mm-dd',
          minView : 2
     });
}

if($(".form_date_time").length>0){
     $(".form_date_time").datetimepicker({
          autoclose: true,
          todayBtn: true,
          format: 'yyyy-mm-dd hh:ii'
     });
}

$('body').on('click','.remove_date_time',function(){
     $(this).prev().val('');
});
$('body').on('click','.trigger_date_time',function(){
     $(this).prev().prev().click();
     $(this).prev().prev().trigger('click');
     $(this).prev().prev().focus();
});

if($(".price").length>0){
     $('.price').priceFormat({
          prefix: '',
          suffix: ''
     });
}
if($(".price").length>0){
     $('.date-range').daterangepicker({
          timePicker: false,
          locale: {
               format: 'YYYY-MM-DD'
          }
     });
}


if($('.date-time-range').length>0){
     $('.date-time-range').daterangepicker({
          timePicker: true,
          "timePicker24Hour": true,
          locale: {
               format: 'YYYY-MM-DD HH:mm'
          }
     });
}


$('body').on('change','.upload_file',function(){
     var ele = $(this);
     var formData = new FormData();
     formData.append('file', ele[0].files[0]);
     $.ajax({
          url : url_gb+'/admin/upload_file',
          type : 'POST',
          data : formData,
          processData: false,  // tell jQuery not to process the data
          contentType: false,  // tell jQuery not to set contentType
          success : function(data) {
               ele.closest('.form-group').find('.preview_file').html('<img src="'+data.link_preview+'" class="preview-file">');
               ele.closest('.form-group').find('.value_name_file').val(data.path);
               setTimeout(function(){
                    centerModals();
               },100);
          }
     });
});
