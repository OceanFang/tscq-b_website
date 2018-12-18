<style>
.loader {
  border: 26px solid #f3f3f3;
  border-radius: 50%;
  border-top: 26px solid #7b81b5;
  width: 300px;
  height: 300px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

#loader{
    z-index: 9999;
}
.modal-loader{

	margin: auto;
    top: 30%;
    left: 5%;
}
/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>


<div class="modal fade" id="loader" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-loader">
	<div class="loader"></div>
	</div>
</div>
