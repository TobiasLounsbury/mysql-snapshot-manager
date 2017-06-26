(function($) {

  /**
   * Helper function to show a timed alert message
   *
   * @param msg
   * @param type
   */
  window.bsalert = function bsalert(msg, type) {
    type = type || "warning";
    var alertObj = $("<div class='alert alert-" + type + "' role='alert'>" + msg + "</div>");
    alertObj.hide();
    $("#statusMessages").append(alertObj);
    alertObj.slideDown();
    if(type != "danger") {
      setTimeout(function() {
        alertObj.slideUp("fast", function() {
          alertObj.remove();
        });
      }, 10000);
    }
  };


  /**
   * Helper function to show the modal dialog for confirms and
   * simple single value inputs.
   *
   * @param options
   * @param callback
   */
  window.showModal = function showModal(options, callback) {


    $("#modalForm .modal-message").html(options.message);

    if(options.title) {
      $("#modalForm .modal-title").html(options.title).show();
    } else {
      $("#modalForm .modal-title").hide();
    }

    if(options.yes) {
      if(typeof options.yes == "object") {
        $("#modalForm .btn-yes .btn-label").html(options.yes.label).show();
        
        if(options.yes.class) {
          $("#modalForm .btn-yes").removeClass().addClass("btn btn-yes btn-" + options.yes.class);
        }

        if(options.yes.icon) {
          $("#modalForm .btn-yes .btn-icon").removeClass().addClass("btn-icon glyphicon glyphicon-" + options.yes.icon).show();
        } else {
          $("#modalForm .btn-yes .btn-icon").hide();
        }
        
      } else {
        $("#modalForm .btn-yes .btn-label").html(options.yes).show();
        $("#modalForm .btn-yes .btn-icon").hide();
      }
    } else {
      $("#modalForm .btn-yes").hide();
    }



    if(options.no) {
      if(typeof options.no == "object") {
        $("#modalForm .btn-no .btn-label").html(options.no.label).show();

        if(options.no.class) {
          $("#modalForm .btn-no").removeClass().addClass("btn btn-no btn-" + options.no.class);
        }

        if(options.no.icon) {
          $("#modalForm .btn-no .btn-icon").removeClass().addClass("btn-icon glyphicon glyphicon-" + options.no.icon).show();
        } else {
          $("#modalForm .btn-no .btn-icon").hide();
        }

      } else {
        $("#modalForm .btn-no .btn-label").html(options.no).show();
        $("#modalForm .btn-no .btn-icon").hide();
      }
    } else {
      $("#modalForm .btn-no").hide();
    }

    if(options.showInput) {
      $("#modalForm .modal-input-wrapper").show();
    } else {
      $("#modalForm .modal-input-wrapper").hide();
    }


    if(callback) {
      window.msmModalCallback = callback;
    } else {
      window.msmModalCallback = false;
    }


    //initialize the modal
    $('#modalForm').modal();
  };

  //Holder for the modal callback
  window.msmModalCallback = false;


  /**
   * Function to trigger deleting projects.
   *
   * @param project
   */
  window.deleteProject = function deleteProject(project) {
    showModal(
      {
        message: "Are you sure you want to delete this project and all of its snapshots?",
        title: "Delete Project?",
        yes: {label: "Delete Project", "class": "danger", icon: "trash"},
        no: "Cancel",
        showInput: false
      },
      function() {
        window.location.href = 'index.php?action=delete&project=' + project;
      }
    );
  };


  /**
   * Function to trigger deleting a snapshot.
   *
   * @param project
   */
  window.deleteSnapshot = function deleteSnapshot(project, snapshot) {
    showModal(
      {
        message: "Are you sure you want to delete this Snapshot?",
        title: "Delete Snapshot?",
        yes: {label: "Delete Snapshot", "class": "danger", icon: "trash"},
        no: "Cancel",
        showInput: false
      },
      function() {
        window.location.href = 'index.php?action=delete&project=' + project + '&snapshot=' + snapshot;
      }
    );
  };



  /**
   * Function to trigger creating a snapshot.
   *
   * @param project
   */
  window.createSnapshot = function createSnapshot(project) {
    showModal(
      {
        message: "Please provide a name for this new snapshot",
        title: "Create Snapshot",
        yes: {label: "Create Snapshot", "class": "success", icon: "download-alt"},
        no: "Cancel",
        showInput: true
      },
      function(snapshotName) {
        showLoadingOverlay();
        var parsedName = snapshotName.replace(/ /g, "_").toLowerCase();
        window.location.href = 'index.php?action=snapshot&project=' + project + '&snapshotName=' + parsedName;
      }
    );
  };


  /**
   * Function to trigger restoration of a snapshot.
   *
   * @param project
   * @param snapshot
   */
  window.restoreSnapshot = function restoreSnapshot(project, snapshot) {
    showModal(
      {
        message: "Are you sure you want to restore this snapshot?",
        title: "Restore?",
        yes: {label: "Restore Snapshot", "class": "success", icon: "refresh"},
        no: "Cancel",
        showInput: false
      },
      function() {
        showLoadingOverlay();
        window.location.href = 'index.php?action=restore&project=' + project + '&snapshot=' + snapshot;
      }
    );
  };


  /**
   * Function to display info for a snapshot.
   *
   * @param project
   */
  window.snapshotInfo = function snapshotInfo(project, snapshot) {
    bsalert("Snapshot Info is not yet implemented", "info");
  };




  window.showLoadingOverlay = function showLoadingOverlay() {
    $("#loading-overlay").fadeIn("fast");
  };

  window.hideLoadingOverlay = function hideLoadingOverlay() {
    $("#loading-overlay").fadeOut("fast");
  };



  /**
   * The functions that need to be run after the page has been rendered
   */
  $("document").ready(function() {

    //wire up the ability to dismiss messages
    $("#statusMessages").click(function(e) {
      var obj = $(e.target);
      if(obj.hasClass("alert")) {
        obj.slideUp("fast", function() {
          obj.remove();
        });
      }
    });

    //Focus the input when the modal is shown
    $('#modalForm').on('shown.bs.modal', function () {
      if($(".modal-input-wrapper").is(":visible")) {
        $('#modal-input').focus();
      }
    });

    //Handle Modal Submit
    $("#modalFormObject").submit(function(event) {
      if(msmModalCallback) {
        if($(".modal-input-wrapper").is(":visible")) {
          msmModalCallback($('#modal-input').val());
        } else {
          msmModalCallback();
        }
      }
      $('#modalForm').modal('hide');
      event.preventDefault();
      return false;
    });


    //Auto-load any selects that have the select2 class
    $(".autoload-select2").select2();


    //Grab a random loading gif from giphy
    var xhr = $.get("http://api.giphy.com/v1/gifs/random?tag=loading&api_key=dc6zaTOxFJmzC&rating=pg");
    xhr.done(function(data) {
      if(data && data.data && data.data.image_url) {
        $("#loading-overlay").css('background-image', 'url(' + data.data.image_url + ')');
      }
    });


  });

})(jQuery);
