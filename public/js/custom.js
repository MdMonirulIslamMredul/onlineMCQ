
// for right button click off
document.addEventListener("contextmenu", function(e){
    e.preventDefault();
}, false);
// for right button click off


$(document).ready(function () {
   
   

});


// Begin:: Exam Start Time
function getTimeRemaining(endtime) {
   const total = Date.parse(endtime) - Date.parse(new Date());
   const seconds = Math.floor((total / 1000) % 60);
   const minutes = Math.floor((total / 1000 / 60) % 60);
   const hours = Math.floor((total / (1000 * 60 * 60)) % 24);
   //const days = Math.floor(total / (1000 * 60 * 60 * 24));
   
   return {
     total,
    // days,
     hours,
     minutes,
     seconds
   };
 }
 
 function initializeClock(id, endtime) {
   const clock = document.getElementById(id);
   //const daysSpan = clock.querySelector('.days');
   const hoursSpan = clock.querySelector('.hours');
   const minutesSpan = clock.querySelector('.minutes');
   const secondsSpan = clock.querySelector('.seconds');
 
   function updateClock() {
     const t = getTimeRemaining(endtime);
 
     //daysSpan.innerHTML = t.days;
     hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
     minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
     secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);
 
     if (t.total <= 0) {
       clearInterval(timeinterval);
       alert("Time's up");
       document.getElementById('examCompleteButton').click();
     }
   }
 
   updateClock();
   const timeinterval = setInterval(updateClock, 1000);
 }
 
 var examTime = $('#examTime').val();
 //alert(examTime);
 if(examTime != '') {
   const deadline = new Date(Date.parse(new Date()) + examTime*60*1000);
   initializeClock('clockdiv', deadline);
 }

// End:: Exam Start Time


// Begin:: apply Coupon
function ApplyCoupon(){
   var inputs = $('#couponCode').val();
   var getSubtotal = $('#cart_page_subtotal').text();
   //alert(getSubtotal);
   if(inputs == ''){
      Toastify({
         text: '⚠️ Coupon is empty',
         backgroundColor: "linear-gradient(to right, #F50057, #F9A826)",
         className: "error",
       }).showToast();
   }
   else {
      $.ajax({
         url:'/checkcouponCode',
         method:"GET",
         data:{ 
            code:inputs,
            subtotal:getSubtotal,
         },
         success:function(response){
            if(response['status'] == 'not'){
               Toastify({
                  text: response['reason'],
                  backgroundColor: "linear-gradient(to right, #F50057, #F9A826)",
                  className: "error",
                }).showToast();
            }
            else if(response['status'] == 'yes'){
               $('#couponIDforCheckout').val(response['couponID']);
               $('#couponValue').val(response['d_amount']);
               $('#maxCValue').val(response['d_max_am']);
               $('#couponType').val(response['dtype']);
               $('#minimumBuyAm').val(response['minimum_buy_am']);
               TotalPriceCalc();
               
            }
            
         }
      });
   }

   
   //alert(inputs);
}
// End:: apply Coupon


//Begin:: Blog Load More Button
function BlogLoadMoreBangla() {

   var lang = 'bangla';
   var lastID = $('#BlogLastID').val();
   $.ajax({
      cache: false,
      url: '/Blog_load_more_using_ajax',
      data:{
         lastID:lastID,
         lang: lang,
      },
      method: "GET",
      success: function (response) {
         $('#BlogLastID').val(response['upLastID']);
         $('#blog_body').append(response['output']);
         if(response['noMorePSts'] == 'no'){
            var addPRODUCTbutton = document.getElementById("LoadMoreButtonRow");
            addPRODUCTbutton.classList.add("d-none");
         }
          
      }
  });
}

function BlogLoadMoreEnglish() {
   var lang = 'english';
   var lastID = $('#BlogLastID').val();
   $.ajax({
      cache: false,
      url: '/Blog_load_more_using_ajax',
      data:{
         lastID:lastID,
         lang: lang,
      },
      method: "GET",
      success: function (response) {
         $('#BlogLastID').val(response['upLastID']);
         $('#blog_body').append(response['output']);
         if(response['noMorePSts'] == 'no'){
            var addPRODUCTbutton = document.getElementById("LoadMoreButtonRow");
            addPRODUCTbutton.classList.add("d-none");
         }
          
      }
  });
}

//End:: Blog Load More Button












