@section('script')
    <script src="/assets/js/panel/settings.js"></script>
@endsection

<div class="modal" id="addSupportModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Kind Of Work</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="add_service">
          <input type="hidden" name="id" id="service_id">
          <div class="service-area">
             <label for="name">Subject</label>
             <input type="text" name="name" id="service_name" maxlength="100" >
             <div id="name-error" class="validation-error"></div>

             <label for="name">Status</label>
             <input type="text" name="name" id="service_name" maxlength="100">
             <div id="name-error" class="validation-error"></div>

             <label for="name">Ticket id</label>
             <input type="text" name="name" id="service_name" maxlength="100">
             <div id="name-error" class="validation-error"></div>

             <label for="name">Priority</label>
             <input type="text" name="name" id="service_name" maxlength="100">
             <div id="name-error" class="validation-error"></div>

             <label for="name">Category</label>
             <input type="text" name="name" id="service_name" maxlength="100">
             <div id="name-error" class="validation-error"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveService()">Save</button>
      </div>
    </div>
  </div>
</div>

<script src="/assets/js/panel/workspace.js"></script>


