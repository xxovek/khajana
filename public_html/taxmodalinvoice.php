<div class="modal modal-center fade" id="TaxModal" tabindex="-1">
  <div class="modal-dialog" style="height: 453px;">
    <div class="modal-header">
      <input type="hidden" id="hiddenitemtax"/>
    </div>
    <div class="modal-content" style="border: 2px solid gray;">
    <form data-provide="validation" data-disable="false" id="TaxData">
      <div class="modal-body">
        <div class="form-group">
          <h5>Add New Tax</h5>
        </div>
        <div class="form-group">
            <label for="CategoryName" class="require">Tax Type</label>
            <select data-provide="selectpicker" class="form-control form-control-sm" id="TaxType" name="TaxType"  title="select Tax Type" required>
              <option value="GST">GST</option>
              <option value="VAT">VAT</option>
            </select>
          <!-- <input type="text" class="form-control form-control-sm" id="TaxType" name="TaxType" data-placement="bottom" data-provide="tooltip" title="Example:VAT,GST" required> -->
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group">

            <label for="CategoryName" class="require">Tax(%)</label><span id="taxavl" style="float:right"></span>
          <input type="text" class="form-control form-control-sm" id="TaxPercent" name="TaxPercent" data-placement="bottom" onchange="checktaxaval()" data-provide="tooltip" title="Example:18%,14%,0.15%" onkeypress="return isNumberKey(event);" required>
            <div class="invalid-feedback"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-bold btn-pure btn-primary" onclick="additemtax();">Save and close</button>
      </div>
    </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="../js/TaxModal.js"></script>
