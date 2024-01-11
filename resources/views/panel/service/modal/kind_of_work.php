@section('script')
    <script src="/assets/js/panel/settings.js"></script>
@endsection

<div class="modal" id="kind_of_work" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Kind Of Work</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="add_service">
          <input type="hidden" name="id" id="work_id">
          <div class="service-area">
             <label for="name">Name</label>
             <input type="text" name="name" id="name" maxlength="60" oninput="event.target.value = event.target.value.replace(/[^A-Za-z]/g, '');">
             <div id="name-error" class="validation-error"></div>

             <label for="name">Description</label>
             <input type="text" name="description" id="description" maxlength="60" oninput="event.target.value = event.target.value.replace(/[^A-Za-z]/g, '');">
             <div id="name-error" class="validation-error"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveKindOfWork()">Save</button>
      </div>
    </div>
  </div>
</div>

<script src="/assets/js/panel/settings.js"></script>


