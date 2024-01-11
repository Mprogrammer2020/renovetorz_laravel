<style>
  h3{
    -moz-osx-font-smoothing: grayscale;
    font-size: 24px;
    font-weight: 500;
    line-height: 1;
    color: #343434;
    display: flex;
    justify-content: center;
    background: #fff;
    padding: 0 50px 40px;
  }
  img{
    width: 10%;
    margin-left: 45%;
    margin-top: 10%;
  }
  #error_message{
    color: #a13d55;
  }
</style>
<?php 
	$workSpaceName = workSpaceGroups()
?>
<!-- Add New Work Space -->
<!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create new space</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div> -->
      <!-- <div class="modal-body">
        <img src="{{asset('upload/images/logo/lXnW-collapsed-officekit-logo.png')}}" alt="">
        <h3>Create New Space</h3>
        <form>
	  <label for="name">Name space</label>
	  <input type="text" name="name" id="name_space" class="form-control" required>
	  <span class="name_space_error text-danger" ></span>
	  </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add_new_work_space">Save changes</button>
      </div>
    </div>
  </div>
</div> --> 



<div class="modal fade" id="templateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Select Template</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
	  <form>

    <input type="hidden" name="workspacename" id="workSpaceName" value="11">
      <div class="row">
      <div class="col-6">
	  <label for="name">Template</label> 
      <ul id="template_id">
        <li value="Blog">Blog</li>
        <li value="Ecommerce">Ecommerce</li>
        <li value="Development">Development</li>
        <li value="Advertisement">Advertisement</li>
        <li value="Custom">Custom</li>
        <li value="Social media">Social media</li>
      </ul>
	    <!-- <select class="drop-down form-control" id="template_id"> 
        <option selected disabled> Select template</option>
        @foreach($workSpaceName as $details)
        <option value="{{$details->id}}">{{$details->name}}</option>
        @endforeach
        </select> -->
      </div>
      <div class="col-6">
          <label for="name">Activies Status</label> 
            <table class="table" id="table_id">
              <tbody>
              </tbody>
            </table>
        </div>
        <div id="error_message"></div>
       </div>
	  </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add_category">Save changes</button>
      </div>
    </div>
  </div>
</div>

