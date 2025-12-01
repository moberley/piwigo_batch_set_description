<!-- description -->
<div id="batch_set_description_global">
  <label class="font-checkbox"><span class="icon-check"></span><input type="checkbox" name="remove_description"> {'remove description'|@translate}</label>
  <textarea cols="60" rows="6" name="description" class="description-box" id="description" style="overflow-y: hidden; height: 80px;" placeholder="{'Type the description here'|@translate}"></textarea>  
</div>
{html_style}
.description-box {
  font-size: 0.9rem;
  resize: inherit !important;
}
{/html_style}
{footer_script}
$('input[name=remove_description]').on('change', function() {
  if ($(this).is(":checked")) {
    $('#batch_set_description_global textarea').hide();
  } else {
    $('#batch_set_description_global textarea').show();
  }
});
{/footer_script}
