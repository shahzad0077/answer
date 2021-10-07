<!-- Modal -->
<div class="modal fade" id="edit-question" tabindex="-1" role="dialog" aria-labelledby="edit-modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-modalLabel">Edit Question</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group mb-2">
            <label for="validationCustom01">Question Title</label>
            <input type="text" class="form-control input-lg" name="name" id="validationCustom01"
                 required >
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>

        <div class="form-group mb-2">
            <label for="validationCustom01">Slug</label>
            <input type="text" class="form-control input-lg" name="name" id="validationCustom01"
                 required >
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>

        <div class="form-group mb-2">
            <label for="validationCustom01">Subject</label>
            <select class="form-control input-lg">
                <option value="">Physics</option>
                <option value="">Mathematics</option>
                <option value="">English</option>
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="add-answer" tabindex="-1" role="dialog" aria-labelledby="edit-modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-modalLabel">Add Answer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group mb-2">
            <label for="validationCustom01">Question Title</label>
            <input type="text" class="form-control input-lg" name="name" id="validationCustom01"
                 required >
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>
        <div class="form-group mb-2">
            <label for="validationCustom01">Slug</label>
            <input type="text" class="form-control input-lg" name="name" id="validationCustom01"
                 required >
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="answerviewmodal" tabindex="-1" role="dialog" aria-labelledby="edit-modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-modalLabel">View Answer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group mb-2">
            <p id="answer"></p>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $("#customCheck1").click(function(){
      $('input:checkbox').not(this).prop('checked', this.checked);
  });
</script>