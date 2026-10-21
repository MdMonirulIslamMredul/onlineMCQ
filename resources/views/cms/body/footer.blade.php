
<footer class="main-footer">
        <div class="footer-left">
          <div class="bullet"></div> {{ $company_info->footer_credit ?? null }}</a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>
  <!-- General JS Scripts -->
  <script src="{{ asset('backend/assets/js/app.min.js') }}"></script>
  <!-- JS Libraies -->
  <script src="{{ asset('backend/assets/bundles/chartjs/chart.min.js') }}"></script>
  <script src="{{ asset('backend/assets/bundles/apexcharts/apexcharts.min.js') }}"></script>
  <!-- Page Specific JS File -->
  <script src="{{ asset('backend/assets/js/page/index.js') }}"></script>
  <!-- Template JS File -->
  <script src="{{ asset('backend/assets/js/scripts.js') }}"></script>
  <!-- Custom JS File -->
  <script src="{{ asset('backend/assets/js/custom.js') }}"></script>

  <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
  <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
  <script src="{{ asset('js/sweetalert.min.js') }}"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

  <!-- lazyload js-->
  <script src="{{ asset('js/lozad.min.js') }}"></script>

  <script src="{{ asset('backend/datatable/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('backend/datatable/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('backend/datatable/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('backend/datatable/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('backend/datatable/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('backend/datatable/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('backend/datatable/jszip/jszip.min.js') }}"></script>
  <script src="{{ asset('backend/datatable/pdfmake/pdfmake.min.js') }}"></script>
  <script src="{{ asset('backend/datatable/pdfmake/vfs_fonts.js') }}"></script>
  <script src="{{ asset('backend/datatable/datatables-buttons/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('backend/datatable/datatables-buttons/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('backend/datatable/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

  @if(session('status'))
    <script>
        swal("Success!", "{{ session('status') }} ", "success");
    </script>
  @endif

  @if(session('adminError'))
    <script>
      swal({
          title: "Error!",
          text: "{{ session('adminError') }}",
          icon: "error",
        });
    </script>
  @endif


  <script>
    $(document).ready(function () {

      totalWritten_review_sum()



    });






    // Begin:: category name to url start
    $(document).on("click change paste keyup cut select", "#category_name", function() {
      var catName = $("#category_name").val();
      var replace_path = catName.replaceAll(" ", "-");
      var new_url = replace_path.toLowerCase();
      $("#category_url").val(new_url);
    });
    // End:: category name to url start

    // Begin:: Product Variation start

    const observer = lozad();
observer.observe();

      // variation change
    function checkvariation(){
	    var val = $("#variation").val();
      //console.log(val);
	    if(val=="simple"){
	        $(".variation").addClass("d-none");
	    }else{
	         $(".variation").removeClass("d-none");
	    }
	  }

  var count_id = 0;


//Begin:: Add MCQ Questions
  function AddMCQTr() {

    var quesNum = $('#numBerOfQuestions').val();
    //var serail = $('#numserial').val();

    var serail = $('#MCQquestionsTable >tbody >tr').length;



if(serail <= 10){
    if(quesNum == 1) {

      $("#MCQquestionsTable tr:last").after('<tr id=""><td><div class="card"><div class="card-body"><div class="form-row"><div class="col-md-1 text-center"><p style="background-color: #544AF4; padding: 5px; border-radius: 20px; font-size: 20px; color: #fff;">'+quesNum+'</p></div><div class="form-group col-md-11"><input type="hidden" name="QID[]" value="0"><textarea id="Q'+quesNum+'" name="questions[]" class="form-control" id="" required rows="3"></textarea></div><div class="form-group col-md-4"><input type="text" name="optn1[]" placeholder="Option 1" class="form-control" id="" required></div><div class="form-group col-md-4"><input type="text" name="optn2[]" placeholder="Option 2" class="form-control" id="" required></div><div class="form-group col-md-4"><input type="text" name="optn3[]" placeholder="Option 3" class="form-control" id="" required></div><div class="form-group col-md-4"><input type="text" name="optn4[]" placeholder="Option 4" class="form-control" id="" required></div><div class="form-group col-md-4"><input type="text" name="optn5[]" placeholder="Option 5 (Optional)" class="form-control" id=""></div><div class="form-group col-md-4"><select name="rightAns[]" class="form-control" id="" required><option value="">-- Select Ans --</option><option value="1">Option 1</option><option value="2">Option 2</option><option value="3">Option 3</option><option value="4">Option 4</option><option value="5">Option 5</option></select></div><div class="form-group col-md-8"><label for="inputEmail4">Right Ans Description</label><textarea class="form-control" name="writeAnsDes[]" id="" rows="3"></textarea></div><div class="form-group col-md-2"><label for=""> <span class="text-danger">*</span> Right Mark</label><input type="text" name="mark[]" value="1" class="form-control" id="" required></div><div class="form-group col-md-2"><label for=""> <span class="text-danger">*</span>Negative Mark</label><input type="text" name="negativeMark[]" value="-1" class="form-control" id="" required></div></div></div></div></td></tr>');
      Toastify({
          text: "New Question Template Added",
          backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
          className: "error",
        }).showToast();

        $('#noQtr').remove();
        var updatedQnum = parseInt(quesNum) + parseInt(1);
         var serail=parseInt(quesNum);
         console.log(serail);
        $('#numBerOfQuestions').val(updatedQnum);
          $('#numserial').val(serail);
    }
    else {
      var preQNum = parseInt(quesNum) - parseInt(1);
      var preQ = $('#Q'+preQNum).val();
      if(preQ != '') {
        $("#MCQquestionsTable tr:last").after('<tr id=""><td><div class="card"><div class="card-body"><div class="form-row"><div class="col-md-1 text-center"><p style="background-color: #544AF4; padding: 5px; border-radius: 20px; font-size: 20px; color: #fff;">'+quesNum+'</p></div><div class="form-group col-md-11"><input type="hidden" name="QID[]" value="0"><textarea id="Q'+quesNum+'" name="questions[]" class="form-control" id="" required rows="3"></textarea></div><div class="form-group col-md-4"><input type="text" name="optn1[]" placeholder="Option 1" class="form-control" id="" required></div><div class="form-group col-md-4"><input type="text" name="optn2[]" placeholder="Option 2" class="form-control" id="" required></div><div class="form-group col-md-4"><input type="text" name="optn3[]" placeholder="Option 3" class="form-control" id="" required></div><div class="form-group col-md-4"><input type="text" name="optn4[]" placeholder="Option 4" class="form-control" id="" required></div><div class="form-group col-md-4"><input type="text" name="optn5[]" placeholder="Option 5 (Optional)" class="form-control" id=""></div><div class="form-group col-md-4"><select name="rightAns[]" class="form-control" id="" required><option value="">-- Select Ans --</option><option value="1">Option 1</option><option value="2">Option 2</option><option value="3">Option 3</option><option value="4">Option 4</option><option value="5">Option 5</option></select></div><div class="form-group col-md-8"><label for="inputEmail4">Right Ans Description</label><textarea class="form-control" name="writeAnsDes[]" id="" rows="3"></textarea></div><div class="form-group col-md-2"><label for=""> <span class="text-danger">*</span> Right Mark</label><input type="text" name="mark[]" value="1" class="form-control" id="" required></div><div class="form-group col-md-2"><label for=""> <span class="text-danger">*</span>Negative Mark</label><input type="text" name="negativeMark[]" value="-1" class="form-control" id="" required></div></div></div></div></td></tr>');

        Toastify({
            text: "New Question Template Added",
            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
            className: "error",
          }).showToast();
          var updatedQnum = parseInt(quesNum) + parseInt(1);
          var serail=parseInt(quesNum);

          $('#numBerOfQuestions').val(updatedQnum);
          $('#numserial').val(serail);

      }
      else {
        Toastify({
          text: "Please Complete Previous Questions!",
          backgroundColor: "linear-gradient(to right, #F50057, #1B1F85)",
          className: "error",
        }).showToast();
      }
    }
}else{
     Toastify({
          text: "You Have to add 10 questions at a time. Please add these 10 questions and after that add again.",
          backgroundColor: "linear-gradient(to right, #F50057, #1B1F85)",
          className: "error",
        }).showToast();
}
  }
  //End:: Add MCQ Questions

  //Begin:: Add Written Questions
  function AddWrittenQTr() {
console.log("mesba");
    var quesNum = $('#numBerOfQuestions').val();
var serail = $('#numserial').val();


if(serail <= 9){
    if(quesNum == 1) {
      $("#WrittenQuestionsTable tr:last").after('<tr><td><div class="card"><div class="card-body"><div class="form-row"><div class="col-md-1 text-center"><p style="background-color: #544AF4; padding: 5px; border-radius: 20px; font-size: 20px; color: #fff;">'+quesNum+'</p></div><div class="form-group col-md-11"><input type="hidden" name="QID[]" value="0"><textarea class="form-control" name="questions[]" required id="WQ'+quesNum+'" rows="3"></textarea></div><div class="form-group col-md-10"><label for="inputEmail4">Ans</label><textarea class="form-control" name="ans[]" rows="3"></textarea></div><div class="form-group col-md-2"><label for=""> <span class="text-danger">*</span>Mark</label><input type="text" name="mark[]" placeholder="Mark" class="form-control" id="" value="" required></div></div></div></div></td></tr>');
      Toastify({
          text: "New Question Template Added",
          backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
          className: "error",
        }).showToast();

        $('#noQtr').remove();
        var updatedQnum = parseInt(quesNum) + parseInt(1);
           var serail=parseInt(quesNum);
        $('#numBerOfQuestions').val(updatedQnum);
        $('#numserial').val(serail);
    }
    else {
      var preQNum = parseInt(quesNum) - parseInt(1);
      var preQ = $('#WQ'+preQNum).val();
      if(preQ != '') {
        $("#WrittenQuestionsTable tr:last").after('<tr><td><div class="card"><div class="card-body"><div class="form-row"><div class="col-md-1 text-center"><p style="background-color: #544AF4; padding: 5px; border-radius: 20px; font-size: 20px; color: #fff;">'+quesNum+'</p></div><div class="form-group col-md-11"><input type="hidden" name="QID[]" value="0"><textarea class="form-control" name="questions[]" required id="WQ'+quesNum+'" rows="3"></textarea></div><div class="form-group col-md-10"><label for="inputEmail4">Ans</label><textarea class="form-control" name="ans[]" rows="3"></textarea></div><div class="form-group col-md-2"><label for=""> <span class="text-danger">*</span>Mark</label><input type="text" name="mark[]" placeholder="Mark" class="form-control" id="" value="" required></div></div></div></div></td></tr>');
        Toastify({
            text: "New Question Template Added",
            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
            className: "error",
          }).showToast();
          var updatedQnum = parseInt(quesNum) + parseInt(1);
          var serail=parseInt(quesNum);
          $('#numBerOfQuestions').val(updatedQnum);
          $('#numserial').val(serail);
      }
      else {
        Toastify({
          text: "Please Complete Previous Questions!",
          backgroundColor: "linear-gradient(to right, #F50057, #1B1F85)",
          className: "error",
        }).showToast();
      }
    }
    }else{
        Toastify({
          text: "You Have to add 10 questions at a time. Please add these 10 questions and after that add again.",
          backgroundColor: "linear-gradient(to right, #F50057, #1B1F85)",
          className: "error",
        }).showToast();
    }
}
//End:: Add Written Questions


//Begin:: Set Written ans Mark
function setWrittenRMark(qid) {
  var userID = $('#userID').val();
  var rightMark = $('#QA'+qid).val();

  $.ajax({
      url: '/cms/set-written-ans-mark',
      type: "GET",
      data : {
          qid:qid,
          userID:userID,
          mark:rightMark
      },
      dataType: "json",
      success:function(data) {
        if(data['status'] == 'yes') {
          Toastify({
            text: "Mark Update Successfully",
            backgroundColor: "linear-gradient(to right, #544AF4, #544AF4)",
            className: "error",
          }).showToast();
          totalWritten_review_sum()
        }

      }
  });

}
//End:: Set Written ans Mark

//Begin:: Change Written Exam Review Status
function Change_Written_Review_Status() {
  var status_value = document.getElementById("ChangeCMSWStatus").value;
  var examID = $('#examID').val();
  var userID = $('#userID').val();

  $.ajax({
      url: '/cms/set-written-result-status',
      type: "GET",
      data : {
          status:status_value,
          userID:userID,
          examID:examID
      },
      dataType: "json",
      success:function(data) {
        if(data['status'] == 'yes') {
          swal({
            title: "Success!",
            text: "Exam Review Status Changed.",
            icon: "success",
          });
        }

      }
  });

}
//End:: Change Written Exam Review Status

//Begin:: Total Sum of Written exam
function totalWritten_review_sum() {
  var examID = $('#examID').val();
  var userID = $('#userID').val();
  if(Number.isInteger(parseInt(examID)) && Number.isInteger(parseInt(userID))) {
    $.ajax({
      url: '/cms/sum-written-result',
      type: "GET",
      data : {
          userID:userID,
          examID:examID
      },
      dataType: "json",
      success:function(data) {
        if(data['status'] == 'yes') {
          $('#AnsrightMark').text(data['totalSum']);
        }
      }
  });
  }
}
//End:: Total Sum of Written exam

//Begin:: Set Note in Written exam
function SetNote(qid) {
  var userID = $('#userID').val();
  var note = $('#N'+qid).val();

  if(note != ''){
    $.ajax({
      url: '/cms/set-written-ans-note',
      type: "GET",
      data : {
          qid:qid,
          userID:userID,
          note:note
      },
      dataType: "json",
      success:function(data) {
        if(data['status'] == 'yes') {
          Toastify({
            text: "Note Update Successfully",
            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
            className: "error",
          }).showToast();

        }

      }
  });
  }
  else {
    Toastify({
      text: "Note is Empty!",
      backgroundColor: "linear-gradient(to right, #F50057, #1B1F85)",
      className: "error",
    }).showToast();

  }
}
//End:: Set Note in Written exam







  function AddVariation(variationID,variation_name) {

      var lowerCase = variation_name.toLowerCase();
      if(lowerCase == 'color' || lowerCase == 'colour'){
        $("#variation_table tr:last").after('<tr id="attribute_id_'+count_id+'"><td><input type="hidden" name="product_variation_id[]" value="new"><input type="hidden" name="variation_id[]" value="'+variationID+'">'+variation_name+'</td><td><input type="color" name="attribute[]" class="form-control"></td><td><input type="number" name="price[]" class="form-control" step=any></td><td class="text-center"><i onclick="delete_row(\'attribute_id_'+count_id+'\')" style="font-size: 20px;" class="fas fa-trash-alt text-danger" aria-hidden="true"></i></td></tr>');
      }
      else {
        $("#variation_table tr:last").after('<tr id="attribute_id_'+count_id+'"><td><input type="hidden" name="product_variation_id[]" value="new"><input type="hidden" name="variation_id[]" value="'+variationID+'">'+variation_name+'</td><td><input type="text" name="attribute[]" class="form-control"></td><td><input type="number" name="price[]" class="form-control" step=any></td><td class="text-center"><i onclick="delete_row(\'attribute_id_'+count_id+'\')" style="font-size: 20px;" class="fas fa-trash-alt text-danger" aria-hidden="true"></i></td></tr>');
      }
      Toastify({
        text: "New Variation Added",
        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
        className: "error",
      }).showToast();

      count_id++;
  }
  // delete variation attribute table row
  function delete_row(id){
    $("#"+id).remove();
      Toastify({
        text: "Variation Removed",
        backgroundColor: "linear-gradient(to right, #F50057, #1B1F85)",
        className: "error",
      }).showToast();

	}

  // delete variation attribute DB row
  function dbDeleteRow(id) {
    swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this Attribute",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
          var v_attribute_id = id;
          $.ajax({
            url: '/cms/delete_vari_attribute/'+v_attribute_id,
            type: "POST",
            data : {"_token":"{{ csrf_token() }}"},
            dataType: "json",
            success:function(data) {
              //alert("hello paul");
            }
        });
        var trID = "exist_vari"+v_attribute_id;
        $("#"+trID).remove();
        Toastify({
          text: "Variation Removed",
          backgroundColor: "linear-gradient(to right, #F50057, #1B1F85)",
          className: "error",
        }).showToast();
        //console.log(trID);
      }
    });

  }
// End:: Product Variation start

//Begin:: copy product image path
function copyImageUrl(path) {
  //alert(path);
  var path = path;
  swal({
      title: "Your link is ready",
      text: path,
      icon: "success",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if(willDelete) {
        navigator.clipboard.writeText(path);
        Toastify({
          text: "Link Copied",
          backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
          className: "error",
        }).showToast();
      }
    });
}
//End:: copy product image path



</script>

<script>
    if (typeof CKEDITOR !== 'undefined') {
        CKEDITOR.config.versionCheck = false;
        var ckConfig = {
            versionCheck: false,
            removePlugins: 'notification'
        };
        if (document.getElementById('editor1') || document.querySelector('textarea[name="editor1"]')) {
            try { CKEDITOR.replace( 'editor1', ckConfig ); } catch (e) {}
        }
        if (document.getElementById('editor2') || document.querySelector('textarea[name="editor2"]')) {
            try { CKEDITOR.replace( 'editor2', ckConfig ); } catch (e) {}
        }
        if (document.getElementById('editor3') || document.querySelector('textarea[name="editor3"]')) {
            try { CKEDITOR.replace( 'editor3', ckConfig ); } catch (e) {}
        }
    }
</script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<!-- Begin:: Cat id to Subcat name dependency  -->
<script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
	<script>
         $(document).ready(function() {
        $('#catID').on('change', function() {
            var catID = $(this).val();
            if(catID) {
                $.ajax({
                    url: '/cms/findCatIDTosubCatName/'+catID,
                    type: "GET",
                    data : {"_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    success:function(data) {
                      //console.log(data);
                      if(data){
                        $('#subCat').empty();
                        $('#subCat').focus;
                        $('#subCat').append('<option value="">-- Select Sub-Category --</option>');
                        $.each(data, function(key, value){
                        $('select[name="subCatID"]').append('<option value="'+ value.id +'">' + value.sub_cat_name+ '</option>');
                    });
                  }else{
                    $('#subCat').empty();
                  }
                  }
                });
            }else{
              $('#subCat').empty();
            }
        });
    });
  </script>
  <!-- End:: Cat id to Subcat name dependency  -->



</body>
</html>
