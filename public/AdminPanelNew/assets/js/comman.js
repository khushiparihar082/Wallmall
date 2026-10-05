function showConfirmAlert(
  title,
  confirmCallback,
  icon = "warning",
  confirmButtonText = "Confirm"
) {
  Swal.fire({
    title: title,
    icon: icon,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: confirmButtonText,
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      confirmCallback();
    }
  });
}
function convertJSONtoExcel(jsonData, fileName) {
  const worksheet = XLSX.utils.json_to_sheet(jsonData);
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1");
  const excelBuffer = XLSX.write(workbook, { bookType: "xlsx", type: "array" });
  const data = new Blob([excelBuffer], { type: "application/octet-stream" });
  const url = URL.createObjectURL(data);
  const link = document.createElement("a");
  link.href = url;
  link.download = fileName + ".xlsx";
  link.click();
  URL.revokeObjectURL(url);
}

function showLoader() {
  var loader = document.createElement("div");
  loader.id = "loader";
  document.body.appendChild(loader);

  // Apply CSS styling to the loader element
  loader.style.cssText = `
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
  `;

  var loaderInner = document.createElement("div");
  loaderInner.style.cssText = `
    display: inline-block;
    width: 60px;
    height: 60px;
    position: relative;
    border: 4px solid #3498db;
    border-radius: 50%;
    animation: loader-spin 1s linear infinite;
  `;
  loader.appendChild(loaderInner);

  var loaderPulse = document.createElement("div");
  loaderPulse.style.cssText = `
    content: "";
    display: block;
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 4px solid #f3f3f3;
    border-color: #f3f3f3 transparent #f3f3f3 transparent;
    animation: loader-pulse 1.2s ease-in-out infinite;
  `;
  loaderInner.appendChild(loaderPulse);

  // Add the @keyframes animation definition
  var style = document.createElement("style");
  style.innerHTML = `
    @keyframes loader-spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    @keyframes loader-pulse {
      0% { transform: scale(0.8); }
      50% { transform: scale(1.2); }
      100% { transform: scale(0.8); }
    }
  `;
  document.head.appendChild(style);
}

function stopLoader() {
  var loader = document.getElementById("loader");
  if (loader) {
    loader.parentNode.removeChild(loader);
  }
}
var arrowRight = function (cell, formatterParams, onRendered) {
  return "<i class='fa-lg fa-arrow-circle-o-right' style='color:blue' title='Delete User'></i>";
};
var arrowDown = function (cell, formatterParams, onRendered) {
  return "<i class='fa-lg fa-arrow-circle-down' style='color:blue' title='Delete User'></i>";
};

/**
 * Recursively updates object keys from a source key name to a destination key name
 * @param {object} obj - The object to update
 * @param {string} fromKeyName - The source key name
 * @param {string} toKeyName - The destination key name
 * @returns {void}
 */
function updateObjectKeysName(obj, fromKeyName, toKeyName) {
  for (var key in obj) {
    if (obj.hasOwnProperty(key)) {
      if (typeof obj[key] === "object") {
        updateObjectKeysName(obj[key], fromKeyName, toKeyName); // recursively update keys for nested objects
      }
      if (key === fromKeyName) {
        obj[toKeyName] = obj[key]; // change source key name to destination key name
        delete obj[key]; // delete the old source key name
      }
    }
  }
}

/**
 * Perform an AJAX request using fetch.
 *
 * @param {string} url - The URL to send the request to.
 * @param {string} method - The HTTP method for the request (e.g., 'GET', 'POST').
 * @param {Object} data - The data to send in the request body (optional).
 * @param {Object} headers - The custom headers to include in the request (optional).
 * @param {string} responseType - The type of response to expect ('json', 'html', etc.).
 * @param {string} contentType - The Content-Type header to include in the request (optional).
 * @returns {Promise} - A Promise that resolves to the response data.
 */
function callAjax(
  url,
  method = "GET",
  data = null,
  headers = {},
  responseType = "json",
  contentType = "application/x-www-form-urlencoded"
) {
  const options = {
    method: method,
    headers: headers,
  };
  if (data) {
    if (contentType === "application/x-www-form-urlencoded") {
      // Convert data object to URL-encoded string
      const urlEncodedData = new URLSearchParams();
      for (const key in data) {
        if (Array.isArray(data[key])) {
          // Handle multi-select array data without converting it
          data[key].forEach((value) => {
            // Append field name with [] to indicate array data
            urlEncodedData.append(key + "[]", value);
          });
        } else {
          urlEncodedData.append(key, data[key]);
        }
      }
      options.body = urlEncodedData.toString();
    } else if (contentType === "application/json") {
      // Convert data object to JSON string
      options.body = JSON.stringify(data);
    } else {
      throw new Error("Invalid Content-Type");
    }
    options.headers["Content-Type"] = contentType;
  }
  return fetch(url, options)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      if (responseType === "json") {
        return response.json();
      } else if (responseType === "html") {
        return response.text();
      } else {
        throw new Error("Invalid response type");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      throw error;
    });
}

/**
 * Submit a form using AJAX.
 * @param {string} form_id - The ID of the form to submit.
 * @param {boolean} display_fields_message - Whether to display fields message.
 * @param {boolean} display_toastr_message - Whether to display toastr message.
 * @param {function} successCallback - Callback function to execute on success.
 * @param {function} errorCallback - Callback function to execute on error.
 */
function submitFormWithAjax(
  form_id,
  display_fields_message,
  display_toastr_message,
  successCallback,
  errorCallback
) {
  var formData = new FormData($("#" + form_id)[0]);
  // Clear field Validation
  clearValidation(formData);
  // $('input[type="file"]').each(function (index, element) {
  //   var fileInput = $(this)[0];
  //   if (fileInput.files.length > 0) {
  //     formData.append($(this).attr("name"), fileInput.files[0]);
  //   }
  // });

  $.ajax({
    url: $("#" + form_id).attr("action"),
    type: $("#" + form_id).attr("method"),
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      try {
        // case OK = 200;
        // case CREATED = 201;
        // case NO_CONTENT = 204;

        //   // Client error codes
        // case BAD_REQUEST = 400;
        // case UNAUTHORIZED = 401;
        // case FORBIDDEN = 403;
        // case NOT_FOUND = 404;
        //   // Server error codes
        // case INTERNAL_SERVER_ERROR = 500;
        // case SERVICE_UNAVAILABLE = 503;
        //   // Validation Failed
        // case VALIDATION_FAILED = 422;
        switch (response.status) {
          // Success codes
          case 200:
          case 201:
            $(".success-message-box").removeClass("d-none");
            $("#success-message").html(response.message);
            if (display_toastr_message) {
              displayToastrMessage("success", response.message);
            }
            if (typeof successCallback === "function") {
              try {
                successCallback(response);
              } catch (callbackError) {
                console.error("Success callback error:", callbackError);
              }
            }
            break;
          case 204:
            $(".error-message-box").removeClass("d-none");
            $("#error-message").html(response.message);
            if (display_toastr_message) {
              displayToastrMessage("info", response.message);
            }
            if (typeof errorCallback === "function") {
              try {
                errorCallback(response);
              } catch (callbackError) {
                console.error("Error callback error:", callbackError);
              }
            }
            break;
          case 400:
          case 401:
          case 403:
          case 404:
          case 500:
          case 503:
            $(".error-message-box").removeClass("d-none");
            $("#error-message").html(response.message);
            if (display_toastr_message) {
              displayToastrMessage("error", response.message);
            }
            if (typeof errorCallback === "function") {
              try {
                errorCallback(response);
              } catch (callbackError) {
                console.error("Error callback error:", callbackError);
              }
            }
            break;
          case 422:
            if (display_fields_message) {
              displayFieldsError(response.message, response.errors);
            }
            if (display_toastr_message) {
              displayToastrMessage("error", response.message, response.errors);
            }
            if (typeof errorCallback === "function") {
              try {
                errorCallback(response);
              } catch (callbackError) {
                console.error("Error callback error:", callbackError);
              }
            }
            $(".error-message-box").removeClass("d-none");
            $("#error-message").html(response.message);
            break;
        }
      } catch (error) {
        console.error("Success handler error:", error);
      }
    },
    error: function (xhr, status, error) {
      try {
        if (typeof errorCallback === "function") {
          try {
            errorCallback(xhr.responseText);
          } catch (callbackError) {
            console.error("Error callback error:", callbackError);
          }
        }
        if (display_toastr_message) {
          $(".error-message-box").removeClass("d-none");
          $("#error-message").html(response.message);
          displayToastrMessage("error", errorMessage);
        }
      } catch (error) {
        console.error("Error handler error:", error);
      }
    },
  });
}

function clearValidation(formData) {
  formData.forEach(function (value, key) {
    // Iterate over the FormData entries
    key = key.replace(/[\[\]]/g, "");
    $("#error-" + key).html(""); // Clear the error message for each field
    // Iterate over the FormData entries
    $("#" + key).removeClass("is-invalid"); // Clear the error message for each field
  });
  $(".success-message-box").addClass("d-none");
  $("#success-message").html("");
  $(".error-message-box").addClass("d-none");
  $("#error-message").html("");
}

/**
 * Display fields error messages.
 * @param {string} message - The main error message to be displayed.
 * @param {Object.<string, string>|null} errors - Optional errors object containing field errors. Keys are field names, values are error messages.
 * @returns {void}
 */
function displayFieldsError(message, errors = null) {
  if (errors) {
    $.each(errors, function (key, value) {
      $("#error-" + key).html(value);
    });
    $.each(errors, function (key, value) {
      $("#" + key).addClass("is-invalid");
    });
  }
  $("#error-message").html(message);
}
/**
 * Display Toastr message.
 * @param {string} type - The type of the Toastr message ('success', 'error', 'warning', 'info').
 * @param {string} message - The message to be displayed.
 * @param {object} errors - Optional errors object containing field errors.
 */
function displayToastrMessage(type, message, errors = null) {
  if (typeof toastr === "undefined") {
    console.warn("Toastr is not defined. Unable to display Toastr message.");
    return;
  }
  if (errors) {
    $.each(errors, function (key, value) {
      toastr.error(value);
    });
  } else {
    switch (type) {
      case "success":
        toastr.success(message);
        break;
      case "error":
        toastr.error(message);
        break;
      case "warning":
        toastr.warning(message);
        break;
      case "info":
        toastr.info(message);
        break;
      default:
        toastr.info(message);
    }
  }
}
// ---------------------------------------------------------Create Modal Jquery-ui---------------------------------------------------
function modalCreateAndShow(
  modalId,
  modalTitle,
  modalContent,
  parentModalId,
  customClass
) {
  createModal(modalId, modalTitle, modalContent, parentModalId, customClass);
  openModal(modalId);
}
function createModal(
  modalId,
  modalTitle,
  modalContent,
  parentModalId = "",
  customClass = ""
) {
  var modalHtml = `
<div id="${modalId}" class="modal fade modal-dialog-centered" tabindex="-1" data-parentModalId = "${parentModalId}">
<div class="modal-dialog modal-dialog-centered ${customClass}">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">${modalTitle}</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="destroyModal('${modalId}')"></button>
</div>
<div class="modal-body">
${modalContent}
</div>
</div>
</div>
</div>
`;

  $("body").append(modalHtml);
  $("#" + modalId).modal("show");
}
function destroyModal(modalId) {
  $("#" + modalId).modal("hide");

  $("#" + modalId).on("hidden.bs.modal", function () {
    $(this).modal("dispose").remove();
  });
  $("#" + modalId).remove();
}
function openModal(modalId) {
  $("#" + modalId).modal("show");
}
/**
 * Get form data as a structured object from a HTML form.
 * @param {string} formId - The ID of the HTML form element.
 * @returns {Object} - The structured form data as an object.
 */
function getFormData(formId) {
  // Initialize an empty object to store the form data
  var formData = {};

  // Get the HTML form element by its ID
  var form = document.getElementById(formId);

  // Get all input, textarea, and select elements in the form
  var inputs = form.querySelectorAll("input, textarea, select");

  // Loop through each input, textarea, and select element
  inputs.forEach(function (input) {
    // Get the name and value of the input, textarea, or select
    var name = input.name;
    var value = input.value;

    // Check if the input is a checkbox
    if (input.type === "checkbox") {
      // Set the value to 1 if the checkbox is checked, otherwise set it to 0
      value = input.checked ? 1 : 0;
    } else if (input.tagName === "SELECT") {
      // For select elements, get the selected option value
      if (input.multiple) {
        // If it's a multiple select
        var selectedOptions = Array.from(input.selectedOptions).map(
          (option) => option.value
        );
        // Set the value to an array of selected option values
        value = selectedOptions;
      } else {
        // For single select
        // Get the selected option value
        value = input.options[input.selectedIndex].value;
      }
    }

    // Remove closing square brackets from the field name
    name = name.replace(/\]$/, "");

    // Split the field name into parts using square brackets
    var parts = name.split("[").filter(function (part) {
      return part.trim() !== "";
    });

    // Initialize the current object as formData
    var currentObj = formData;

    // Traverse through the parts to create the nested structure
    parts.forEach(function (part, index) {
      // Check if it's the last part
      if (index === parts.length - 1) {
        // If it's the last part, set the value
        currentObj[part] = value;
      } else {
        // If it's not the last part, initialize an object if it doesn't exist
        currentObj[part] = currentObj[part] || {};
        // Move to the next nested object
        currentObj = currentObj[part];
      }
    });
  });

  // Return the structured form data object
  return formData;
}

function convertObjectToArray(obj) {
  if (Array.isArray(obj)) {
    return obj.map(convertObjectToArray);
  } else if (typeof obj === "object" && obj !== null) {
    return Object.keys(obj).map((key) => convertObjectToArray(obj[key]));
  } else {
    return obj;
  }
}

/**
 * Reset form data as a structured object from a HTML form.
 * @param {string} formId - The ID of the HTML form element.
 */
function resetFormData(formId) {
  // Select the form using the formId
  var form = $("#" + formId);
  form
    .find(
      'input[type="hidden"],input[type="text"], input[type="password"], input[type="email"], input[type="number"], input[type="date"], input[type="radio"], input[type="checkbox"], textarea, select'
    )
    .val("");

  // Clear Selectize.js select inputs
  form.find(".selectized").each(function () {
    var selectize = $(this)[0].selectize;
    if (selectize) {
      selectize.clear();
    }
  });
}
// convert "columns[0][type]" to "columns\\[0\\]\\[type\\]"
function escapeBrackets(inputString) {
  return inputString.replace(/\[/g, "\\[").replace(/\]/g, "\\]");
}
// function initializeSelectize(
//   selectId,
//   options = {},
//   apiUrl = "",
//   apiData = {},
//   valueField = "id",
//   keyField = "name",
//   defaultSelectedValue = null
// ) {
//   // Initialize Selectize
//   var $select = $("#" + selectId).selectize(options);

//   // Load data from API if apiUrl is provided
//   if (apiUrl !== "") {
//     $.ajax({
//       url: apiUrl,
//       type: "POST",
//       data: apiData, // Additional data to send with the request
//       dataType: "json",
//       success: function (response) {
//         if (response.status == 200) {
//           var data = JSON.parse(response.data);
//           // Populate Selectize dropdown with data from API
//           $.each(data, function (index, item) {
//             $select[0].selectize.addOption({
//               value: item[valueField],
//               text: item[keyField],
//             });
//           });

//           // Set default selected value if provided
//           if (defaultSelectedValue !== null) {
//             $select[0].selectize.setValue(defaultSelectedValue);
//           }
//         }
//       },
//       error: function (xhr, status, error) {
//         console.error("Error fetching data from API:", error);
//       },
//     });
//   }

//   // Return an object with methods
//   return {
//     onchange: function (callback) {
//       $select.on("change", function () {
//         var selectedValue = $select[0].selectize.getValue();
//         callback(selectedValue);
//       });
//     },
//     clearOptions: function () {
//       return new Promise(function (resolve) {
//         var selectize = $select[0].selectize;
//         selectize.clear();
//         selectize.clearOptions();
//         resolve();
//       });
//     },
//   };
// }

function initializeSelectize(
  selectId,
  options = {},
  apiUrl = "",
  apiData = {},
  valueField = "id",
  keyField = "name",
  defaultSelectedValue = null,
  optionGroupingFieldName = null // Optional parameter for grouping options
) {
  // Initialize Selectize
  var $select = $("#" + selectId).selectize(options);

  // Load data from API if apiUrl is provided
  if (apiUrl !== "") {
    $.ajax({
      url: apiUrl,
      type: "POST",
      data: apiData, // Additional data to send with the request
      dataType: "json",
      success: function (response) {
        if (response.status == 200) {
          var data = JSON.parse(response.data);

          // Check if grouping is needed
          if (optionGroupingFieldName) {
            // Group data by the specified field
            var groupedData = {};
            $.each(data, function (index, item) {
              var group = item[optionGroupingFieldName];
              if (!groupedData[group]) {
                groupedData[group] = [];
              }
              groupedData[group].push(item);
            });

            // Add grouped options to Selectize
            $.each(groupedData, function (group, items) {
              $select[0].selectize.addOptionGroup(group, { label: group });
              $.each(items, function (index, item) {
                $select[0].selectize.addOption({
                  value: item[valueField],
                  text: item[keyField],
                  optgroup: group,
                });
              });
            });
          } else {
            // Populate Selectize dropdown with data from API
            $.each(data, function (index, item) {
              $select[0].selectize.addOption({
                value: item[valueField],
                text: item[keyField],
              });
            });
          }

          // Set default selected value if provided
          if (defaultSelectedValue !== null) {
            $select[0].selectize.setValue(defaultSelectedValue);
          }
        }
      },
      error: function (xhr, status, error) {
        console.error("Error fetching data from API:", error);
      },
    });
  }

  // Return an object with methods
  return {
    onchange: function (callback) {
      $select.on("change", function () {
        var selectedValue = $select[0].selectize.getValue();
        callback(selectedValue);
      });
    },
    clearOptions: function () {
      return new Promise(function (resolve) {
        var selectize = $select[0].selectize;
        selectize.clear();
        selectize.clearOptions();
        resolve();
      });
    },
  };
}

function setCookie(name, value, days) {
  var expires = "";
  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
    expires = "; expires=" + date.toUTCString();
  }
  document.cookie = name + "=" + value + expires + "; path=/";
}
// Function to get cookie value by key
function getCookie(key) {
  var name = key + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var cookieArray = decodedCookie.split(";");
  for (var i = 0; i < cookieArray.length; i++) {
    var cookie = cookieArray[i].trim();
    if (cookie.indexOf(name) == 0) {
      return cookie.substring(name.length, cookie.length);
    }
  }
  return null; // Return null if cookie with specified key is not found
}
function deleteCookie(key) {
  document.cookie = key + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}
function displayImage(event, previewImageId) {
  var fileInput = event.target; // Get the actual DOM element from the event object
  var previewImage = $("#" + previewImageId);

  // Check if a file is selected
  if (fileInput.files && fileInput.files[0]) {
    var file = fileInput.files[0];
    var maxSize = 500 * 1024; // Maximum file size in bytes (500KB)

    // Check if the file size is less than 500KB
    if (file.size <= maxSize) {
      var reader = new FileReader();

      // When the file is loaded, set the src attribute of the image to the data URL
      reader.onload = function (e) {
        previewImage.attr("src", e.target.result); // Use attr() to set the src attribute
      };

      // Read the file as a data URL
      reader.readAsDataURL(file);
    } else {
      // Reset the file input and alert the user
      fileInput.value = "";
      alert("Please select an image file less than 500KB.");
    }
  } else {
    // If no file is selected, reset the image source
    previewImage.attr("src", "");
  }
}
// var DeleteApiUrl = "";
function deleteRow(data) {
  return new Promise((resolve, reject) => {
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: DeleteApiUrl,
          type: "POST",
          contentType: "application/json",
          data: JSON.stringify(data),
          success: function (response) {
            // Handle success response
            if (response.status == 422) {
              toastr.error(response.message);
              reject(response.message); // Reject promise on specific condition
            } else if (response.status == 200) {
              toastr.success(response.message);
              resolve(response); // Resolve promise with response object
            } else {
              toastr.error(response.message);
              console.error(response);
              reject(response.message); // Reject promise on unexpected response
            }
          },
          error: function (xhr, status, error) {
            // Handle error response
            console.error(xhr.responseText);
            toastr.error("Error deleting row"); // Optionally show a generic error message
            reject(error); // Reject promise on error
          },
        });
      } else {
        // User clicked cancel, handle as needed
        reject("Deletion cancelled by user");
      }
    });
  });
}

/*
 * Initializes or refreshes a DataTable with data fetched from an API.
 * @param {string} table_id - The ID of the HTML table element to initialize or refresh as a DataTable.
 * @param {string} url - The URL of the API endpoint to fetch data from.
 * @param {string} [method="POST"] - The HTTP method for the API request (default is "POST").
 * @param {Object} [parameter={}] - The parameters to send with the API request.
 * @param {function} dataTableSuccessCallBack - A callback function that processes the API response and returns necessary data for DataTable.
 * @param {Object} [headers={}] - The headers to include in the API request.
 */
function DataTableInitialized(
  table_id,
  url = null,
  method = "POST",
  parameter = {},
  dataTableSuccessCallBack = null,
  headers = {},
  afterTableViewCallbackFunction = null,
  rowData = null,
  columnData = null
) {
  // Check if DataTable is already initialized
  if (rowData !== null && columnData !== null) {
    // If rowData and columns are provided, initialize the DataTable with them
    if ($.fn.DataTable.isDataTable("#" + table_id)) {
      // If the DataTable is already initialized, just update the data
      var dataTable = $("#" + table_id).DataTable();
      dataTable.clear().rows.add(rowData).draw();
    } else {
      // Initialize the DataTable with the provided data and columns
      var dataTable = $("#" + table_id).DataTable({
        data: rowData,
        columns: columnData,
        dom: "Bfrtip", // Add the Buttons extension elements
        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
        initComplete: function () {
          if (typeof afterTableViewCallbackFunction === "function") {
            afterTableViewCallbackFunction({ rowData, columns });
          }
        },
      });
      dataTable
        .buttons()
        .container()
        .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");
      $("#datatable_length select").addClass("form-select form-select-sm");
      dataTable.on("draw", function () {
        if (typeof afterTableViewCallbackFunction === "function") {
          afterTableViewCallbackFunction({ rowData, columns });
        }
      });
    }
  } else if (url !== null) {
    if ($.fn.DataTable.isDataTable("#" + table_id)) {
      if (url != null) {
        DataTableApiCall(
          url,
          method,
          parameter,
          dataTableSuccessCallBack,
          headers
        )
          .then(function (data) {
            var dataTable = $("#" + table_id).DataTable();
            // Clear existing data and add new data
            dataTable.clear().rows.add(data.rowData).draw();
            // Add the draw event listener
            dataTable.on("draw", function () {
              if (typeof afterTableViewCallbackFunction === "function") {
                afterTableViewCallbackFunction(data);
              }
            });
          })
          .catch(function (error) {
            console.log("DataTable Error fetching data from server");
          });
      }
    } else {
      // DataTable not initialized, initialize it with API data
      DataTableApiCall(
        url,
        method,
        parameter,
        dataTableSuccessCallBack,
        headers
      )
        .then(function (data) {
          var dataTable = $("#" + table_id).DataTable({
            data: data.rowData,
            columns: data.columns,
            dom: "Bfrtip", // Add the Buttons extension elements
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
            initComplete: function () {
              if (typeof afterTableViewCallbackFunction === "function") {
                afterTableViewCallbackFunction(data);
              }
            },
          });
          dataTable
            .buttons()
            .container()
            .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");
          $("#datatable_length select").addClass("form-select form-select-sm");
          dataTable.on("draw", function () {
            if (typeof afterTableViewCallbackFunction === "function") {
              afterTableViewCallbackFunction(data);
            }
          });
        })
        .catch(function (error) {
          console.log("DataTable Error fetching data from server");
        });
    }
  } else {
    var dataTable = $("#" + table_id).DataTable({
      dom: "Bfrtip", // Add the Buttons extension elements
      buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
    });
    // Handle 'select all' functionality
    $("#selectAll").on("click", function () {
      var rows = dataTable.rows({ search: "applied" }).nodes();
      $('input[type="checkbox"]', rows).prop("checked", this.checked);
    });

    // Handle individual row selection
    $("#" + table_id + " tbody").on("change", ".select-row", function () {
      if (!this.checked) {
        var el = $("#selectAll").get(0);
        if (el && el.checked && "indeterminate" in el) {
          el.indeterminate = true;
        }
      }
    });
  }
}
/*
 * Makes an AJAX request to fetch data from an API.
 * @param {string} url - The URL of the API endpoint.
 * @param {string} [method="POST"] - The HTTP method for the API request (default is "POST").
 * @param {Object} [parameter={}] - The parameters to send with the API request.
 * @param {function} dataTableSuccessCallBack - A callback function that processes the API response and returns necessary data for DataTable.
 * @param {Object} [headers={}] - The headers to include in the API request.
 * @returns {Promise<{rowData: Array, columns: Array}>} A promise that resolves with an object containing rowData (array of objects) and columns (array of column definitions).
 */
function DataTableApiCall(
  url,
  method = "POST",
  parameter = {},
  dataTableSuccessCallBack,
  headers = {}
) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      type: method,
      url: url,
      data: parameter,
      headers: headers,
      success: function (response) {
        if (typeof dataTableSuccessCallBack === "function") {
          var callbackResult = dataTableSuccessCallBack(response);
          var statusValue =
            "status" in callbackResult ? callbackResult.status : null;
          var columns =
            "columns" in callbackResult ? callbackResult.columns : null;
          var rowData = "data" in callbackResult ? callbackResult.data : null;

          if (statusValue === null || columns === null || rowData === null) {
            reject("Invalid callback result");
            return;
          }

          if (statusValue === 200) {
            resolve({ rowData: rowData, columns: columns });
          } else {
            toastr.error(response.message || "Unknown error occurred");
            reject(response.message || "Unknown error occurred");
          }
        } else {
          toastr.error("Success Callback Function Not Found");
          reject("Success Callback Function Not Found");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error occurred: ", error);
        console.log("DataTable Error fetching data from server");
        reject(error);
      },
    });
  });
}

// Initialize CKEditor on textareas with class 'ckeditor-active'
$(".ckeditor-active").each(function () {
  var textareaId = $(this).attr("id");
  CKEDITOR.replace(textareaId, {
    extraAllowedContent: "*[style]",
    allowedContent: true,
    htmlSupport: {
      allow: [
        {
          name: "div",
          attributes: true, // Allow all attributes including style
        },
        {
          name: "span",
          attributes: true, // Allow all attributes including style
        },
        {
          name: "table",
          attributes: true, // Allow all attributes including style and align
        },
        {
          name: "tr",
          attributes: true, // Allow attributes for table rows
        },
        {
          name: "td",
          attributes: true, // Allow attributes for table cells
        },
      ],
    },
  });

  // Handle CKEditor change event
  CKEDITOR.instances[textareaId].on("change", function () {
    // Update corresponding textarea's value with CKEditor's data
    $("#" + textareaId).val(CKEDITOR.instances[textareaId].getData());
  });
});
function enlargeImage(event, primaryImg = null) {
  if (primaryImg == null) {
    var imgSrc = event.target.src; // Get the source of the clicked image
  } else {
    var imgSrc = primaryImg; // Get the source of the clicked image
  }

  // Use SweetAlert to display the image in a modal
  Swal.fire({
    imageUrl: imgSrc,
    imageAlt: "Enlarged Image",
    showCloseButton: true,
    showConfirmButton: false,
    imageWidth: "auto",
    imageHeight: "auto",
    customClass: {
      image: "swal2-image-enlarge", // Custom class for additional styling if needed
    },
  });
}
function getThumbnailImagePath(originalImagePath) {
  // Split the path into components
  let pathComponents = originalImagePath.split("/");

  // Insert the 'thumbnail' folder before the last component
  pathComponents.splice(pathComponents.length - 1, 0, "thumbnail");

  // Join the components back into a full path
  return pathComponents.join("/");
}
// Get time Ago Function
function timeAgo(datetime) {
  const currentDate = new Date();
  const providedDate = new Date(datetime);
  const timeDifference = currentDate - providedDate;
  const seconds = Math.floor(timeDifference / 1000);
  const minutes = Math.floor(seconds / 60);
  const hours = Math.floor(minutes / 60);

  if (hours > 0) {
    return hours === 1 ? "1 hour ago" : `${hours} hours ago`;
  } else if (minutes > 0) {
    return minutes === 1 ? "1 minute ago" : `${minutes} minutes ago`;
  } else {
    return seconds <= 1 ? "just now" : `${seconds} seconds ago`;
  }
}
/**
 * Add a key-value pair to an object if the value is not null, undefined, or an empty string.
 * @param {any} value - The value to check and assign.
 * @param {string} field - The key in the object to which the value should be assigned.
 * @param {Object} obj - The object to which the key-value pair should be added.
 * @returns {Object} The updated object.
 */
function appendDataIfExists(value, field, obj) {
  if (value !== null && value !== undefined && value !== "") {
    obj[field] = value;
  }
  return obj;
}
