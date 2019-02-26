<div class="modal modal-center fade" id="modal-center" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
          <form data-provide="validation" data-disable="false" id="UnitData">
      <div class="modal-header">
        <h5 class="modal-title">Add New Unit</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="UnitName" class="require">Unit Name</label>
          <input type="text" class="form-control form-control-sm" id="UnitName" name="UnitName" data-placement="bottom" data-provide="tooltip" title="Measure this item as per standard unit(UQC) defined under the GST rule Example KGS-kilograms" required>
            <div class="invalid-feedback"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-bold btn-pure btn-primary">Save and close</button>
      </div>
    </form>
    </div>
  </div>
</div>
