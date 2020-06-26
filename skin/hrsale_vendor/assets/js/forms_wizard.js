$(function() {
  $('.smartwizard-example').smartWizard({
    autoAdjustHeight: false,
    backButtonSupport: false,
    useURLhash: false,
    showStepURLhash: false
  });

  // Change markup for vertical wizards
  //

  $('#smartwizard-4 .sw-toolbar').appendTo($('#smartwizard-4 .sw-container'));
  $('#smartwizard-5 .sw-toolbar').appendTo($('#smartwizard-5 .sw-container'));
});