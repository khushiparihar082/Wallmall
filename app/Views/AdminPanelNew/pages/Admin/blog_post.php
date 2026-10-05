<div class="card">
    <!-- <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Blog Post</h4>
        <div>
            <a href="<?= base_url(route_to('create_blog_post')) ?>" class="btn btn-primary" type="button">
                <i class="bx bxs-user-plus"></i> Add Blog Post
            </a>
        </div>
    </div> -->
    <div class="card-body">
        <div class="d-flex justify-content-end table_btn_div mb-2">
            <a href="<?= base_url(route_to('create_blog_post')) ?>">
                <button class="add_form_btn"><i class="bx bx-plus me-2"></i>Add Blog Post</button>
            </a>
        </div>
        <div class="table-responsive">
            <table id="blogPostTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle table-sm"></table>
        </div>
    </div>
</div>
<div class="offcanvas offcanvas-end offcanvas-blogpost" tabindex="-1" id="blogpost" aria-labelledby="blogpostLable">
</div>
</div>


<div id="showsuccess" style="display:none; color:green;"></div>
<div id="showdanger" style="display:none; color:red;"></div>

<script>
var DeleteApiUrl = "<?= base_url(route_to('blog_post_delete_api')) ?>"

function successCallback(response) {
    if (response.status == 200 || response.status == 201) {
        $(".offcanvas button[data-bs-dismiss='offcanvas']").click();
        fetchTableData({
            _autojoin: "Y",
            _select: "*"
        });
    }
}

function errorCallback(response) {
    console.log(response);
}

function deleteBlogPost(blog_id) {
    deleteRow({
            "blog_id": blog_id
        }).then((response) => {
            fetchTableData({
                _autojoin: "Y",
                _select: "*"
            });
        })
        .catch((error) => {
            console.error("Deletion failed or cancelled:", error);
        });
}

function BlogPostDisplay(blog_id) {
    $.ajax({
        type: "post",
        url: "<?= base_url(route_to("BlogPostView")) ?>",
        data: {
            blog_id: blog_id,
        },
        success: function(response) {
            $("#blogpost").html("");
            $("#blogpost").html(response);
        }
    });
}

function successDataTableCallbackFunction(response) {
    var columns = [{
            title: "ID",
            data: "blog_id"
        },
        {
            title: "Title",
            data: "blog_title"
        },
        {
            title: "Publish Date",
            data: "published_at",
            render: function(data, type, row) {
                var date = new Date(data);
                var options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                return date.toLocaleDateString('en-GB', options);
            }
        },
        {
            title: "Image",
            data: null,
            "render": function(data, type, row) {
                return `
                    <img class="image-fluid" style="height:auto; width:100px" src="<?= base_url() ?>/${row.blog_featured_image }" onclick="enlargeImage(event)">
                    `;
            }
        },
        {
            title: "Views",
            data: "blog_views_count"
        },
        {
            title: "User Name",
            data: "fullname"
        },
        {
            title: "Status",
            data: "blog_status",
            render: function(data, type, row) {
                var checked = data == "published" ? 'checked' :
                    ''; // Check if data is "published" to set checked attribute
                var draftChecked = data == "draft" ? 'checked' :
                    ''; // Check if data is "draft" to set checked attribute
                return `
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="isActiveSwitch_${row.blog_id}" ${checked} onchange="change_status(event, ${row.blog_id})">
                <label class="form-check-label" for="isActiveSwitch_${row.blog_id}">${data}</label>
            </div>`;
            }
        },


        {
            "title": "Actions",
            "data": null,
            "render": function(data, type, row) {
                return `
                            <a class="btn btn-sm btn-info" href="<?= base_url(route_to('create_blog_post')) ?>/${row.blog_id }" >
                                <i class="bx bx-edit-alt"></i>
                            </a>
                            <button class="btn btn-sm btn-danger" onclick="deleteBlogPost(${row.blog_id })">
                                <i class="bx bx-trash-alt"></i>
                            </button>
                        `;
            }
        }
    ];
    if (response.status == 200) {
        return {
            "status": response.status,
            "columns": columns,
            "data": JSON.parse(response.data)
        };
    } else {
        return {
            "status": response.status,
            "columns": columns,
            "data": {}
        };
    }
}


function change_status(event, blog_id) {

    var isChecked = event.target.checked;

    $('#isActiveSwitch_' + blog_id).prop('checked', isChecked);

    var blog_status = isChecked ? 'published' : 'draft';

    $.ajax({
        type: "POST",
        url: "<?= base_url(route_to('blog_post_update_api')) ?>",
        data: {
            blog_id: blog_id,
            blog_status: blog_status,

        },
        success: function(response) {
            if (response.status == 200) {
                toastr.success("Changed Successfully");
            } else {
                toastr.error(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX request error:", error);
        }
    });
}

function fetchTableData(parameter = {}) {

    DataTableInitialized(
        'blogPostTable', // table_id
        "<?= base_url(route_to('blog_post_list_api')) ?>", // url
        'POST', // methodt
        parameter, // parameter
        successDataTableCallbackFunction, // dataTableSuccessCallBack

    );
}
$(document).ready(function() {
    fetchTableData({
        _autojoin: "Y",
        _select: "*"
    });
});
</script>