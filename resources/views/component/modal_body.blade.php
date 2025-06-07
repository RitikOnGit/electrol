<style>
/* Modal styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1050;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    width: 80%;
    max-width: 700px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.25);
}

.close-btn {
    float: right;
    font-size: 34px;
    font-weight: bold;
    cursor: pointer;
}

.close-btn:hover {
    color: red;
}
.crossbtndiv{
    display: flex;
    justify-content: end;
    position: absolute;
    right: 10px;
    top: 0px;
}

</style>


<!-- Modal -->
<div class="modal fade" id="Modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg d-flex justify-content-center">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close cancel-button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      @yield('modal-content')
      </div>

    </div>
  </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
       document.querySelectorAll('.cancel-button').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('submit_form').reset(); // Reset the form
            $('#yourModal').modal('hide');
        });
    });
});


</script>
