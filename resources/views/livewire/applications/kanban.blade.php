
        <div class="container-fluid py-4">
            <div class="d-flex m-3">
                <div class="ms-auto d-flex">
                    <div class="pe-4 mt-1 position-relative">
                        <p class="text-secondary text-xs font-weight-bold mb-2">Team members:</p>
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="avatar-group">
                                <a href="javascript:;" class="avatar avatar-sm rounded-circle" data-toggle="tooltip"
                                    data-original-title="Jessica Rowland">
                                    <img alt="Image placeholder" src="{{ asset('assets') }}/img/team-1.jpg">
                                </a>
                                <a href="javascript:;" class="avatar avatar-sm rounded-circle" data-toggle="tooltip"
                                    data-original-title="Audrey Love">
                                    <img alt="Image placeholder" src="{{ asset('assets') }}/img/team-2.jpg"
                                        class="rounded-circle">
                                </a>
                                <a href="javascript:;" class="avatar avatar-sm rounded-circle" data-toggle="tooltip"
                                    data-original-title="Michael Lewis">
                                    <img alt="Image placeholder" src="{{ asset('assets') }}/img/team-3.jpg"
                                        class="rounded-circle">
                                </a>
                                <a href="javascript:;" class="avatar avatar-sm rounded-circle" data-toggle="tooltip"
                                    data-original-title="Lucia Linda">
                                    <img alt="Image placeholder" src="{{ asset('assets') }}/img/team-4.jpg"
                                        class="rounded-circle">
                                </a>
                                <a href="javascript:;" class="avatar avatar-sm rounded-circle" data-toggle="tooltip"
                                    data-original-title="Ronald Miller">
                                    <img alt="Image placeholder" src="{{ asset('assets') }}/img/team-5.jpg"
                                        class="rounded-circle">
                                </a>
                            </div>
                        </div>
                        <hr class="vertical dark mt-0">
                    </div>
                    <div class="ps-4">
                        <button class="btn bg-gradient-info btn-icon-only mb-0 mt-3" data-toggle="modal"
                            data-target="#new-board-modal">
                            <i class="material-icons text-lg">add</i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-3 kanban-container">
                <div class="py-2 min-vh-100 d-inline-flex" style="overflow-x: auto">
                    <div id="myKanban"></div>
                </div>
            </div>
            <div class="modal fade" id="new-board-modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="h5 modal-title">Choose your new Board Name</h5>
                            <button type="button" class="btn close pe-1" data-dismiss="modal"
                                data-target="#new-board-modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="pt-4 modal-body">
                            <div class="mb-4 input-group">
                                <span class="input-group-text">
                                    <i class="far fa-edit"></i>
                                </span>
                                <input class="form-control" placeholder="Board Name" type="text"
                                    id="jkanban-new-board-name" />
                            </div>
                            <div class="text-end">
                                <button class="m-1 btn btn-primary" id="jkanban-add-new-board" data-toggle="modal"
                                    data-target="#new-board-modal">
                                    Save changes
                                </button>
                                <button class="m-1 btn btn-secondary" data-dismiss="modal"
                                    data-target="#new-board-modal">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hidden opacity-50 fixed inset-0 z-40 bg-black" id="new-board-modal-backdrop"></div>
            <div class="modal fade" id="jkanban-info-modal" style="display: none" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="h5 modal-title">Task details</h5>
                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="pt-4 modal-body">
                            <input id="jkanban-task-id" class="d-none" />
                            <div class="input-group input-group-static mb-4">
                                <label>Task Assignee</label>
                                <input class="form-control" placeholder="Task Title" id="jkanban-task-title"
                                    type="text">
                            </div>
                            <div class="input-group input-group-static mb-4">
                                <label>Task Assignee</label>
                                <input class="form-control" placeholder="User" id="jkanban-task-assignee"
                                    type="text">
                            </div>
                            <div class="input-group input-group-static">
                                <textarea class="form-control" placeholder="Task Description"
                                    id="jkanban-task-description" rows="4"></textarea>
                            </div>
                            <div class="alert alert-success d-none">Changes saved!</div>
                            <div class="text-end">
                                <button class="m-1 btn btn-primary" id="jkanban-update-task" data-toggle="modal"
                                    data-target="#jkanban-info-modal">
                                    Save changes
                                </button>
                                <button class="m-1 btn btn-secondary" data-dismiss="modal"
                                    data-target="#jkanban-info-modal">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hidden opacity-50 fixed inset-0 z-40 bg-black" id="jkanban-info-modal-backdrop"></div>
        </div>
@push('js') 
<script>
    // jkanban init
    (function() {
      if (document.getElementById("myKanban")) {
        var KanbanTest = new jKanban({
          element: "#myKanban",
          gutter: "10px",
          widthBoard: "450px",
          click: el => {
            let jkanbanInfoModal = document.getElementById("jkanban-info-modal");

            let jkanbanInfoModalTaskId = document.querySelector(
              "#jkanban-info-modal #jkanban-task-id"
            );
            let jkanbanInfoModalTaskTitle = document.querySelector(
              "#jkanban-info-modal #jkanban-task-title"
            );
            let jkanbanInfoModalTaskAssignee = document.querySelector(
              "#jkanban-info-modal #jkanban-task-assignee"
            );
            let jkanbanInfoModalTaskDescription = document.querySelector(
              "#jkanban-info-modal #jkanban-task-description"
            );
            let taskId = el.getAttribute("data-eid");
            let taskTitle = el.querySelector('p.text').innerHTML;
            let taskAssignee = el.getAttribute("data-assignee");
            let taskDescription = el.getAttribute("data-description");
            jkanbanInfoModalTaskId.value = taskId;
            jkanbanInfoModalTaskTitle.value = taskTitle;
            jkanbanInfoModalTaskAssignee.value = taskAssignee;
            jkanbanInfoModalTaskDescription.value = taskDescription;
            var myModal = new bootstrap.Modal(jkanbanInfoModal, {
              show: true
            });
            myModal.show();
          },
          buttonClick: function(el, boardId) {
            if (
              document.querySelector("[data-id='" + boardId + "'] .itemform") ===
              null
            ) {
              // create a form to enter element
              var formItem = document.createElement("form");
              formItem.setAttribute("class", "itemform");
              formItem.innerHTML = `<div class="input-group">
          <textarea class="form-control" rows="2" autofocus></textarea>
          </div>
          <div class="form-group">
            <button type="submit" class="btn bg-gradient-success btn-sm pull-end">Add</button>
            <button type="button" id="kanban-cancel-item" class="btn bg-gradient-light btn-sm pull-end me-2">Cancel</button>
          </div>`;

              KanbanTest.addForm(boardId, formItem);
              formItem.addEventListener("submit", function(e) {
                e.preventDefault();
                var text = e.target[0].value;
                let newTaskId =
                  "_" + text.toLowerCase().replace(/ /g, "_") + boardId;
                KanbanTest.addElement(boardId, {
                  id: newTaskId,
                  title: text,
                  class: ["border-radius-xl"]
                });
                formItem.parentNode.removeChild(formItem);
              });
              document.getElementById("kanban-cancel-item").onclick = function() {
                formItem.parentNode.removeChild(formItem);
              };
            }
          },
          addItemButton: true,
          boards: [{
              id: "_backlog",
              title: "Backlog",
              item: [{
                  id: "_task_1_title_id",
                  title: "Click me to change title",
                  class: ["border-radius-xl"]
                },
                {
                  id: "_task_2_title_id",
                  title: "Drag me to 'In progress' section",
                  class: ["border-radius-xl"]
                },
                {
                  id: "_task_do_something_id",
                  title: '<img src="{{ asset('assets') }}/img/office-dark.jpg" class="w-100"><span class="mt-3 badge badge-sm bg-gradient-primary">Pending</span><p class="text mt-2">Website Design: New cards for blog section and profile details</p><div class="d-flex"><div> <i class="fa fa-paperclip me-1 text-sm"></i><span class="text-sm">3</span></div><div class="avatar-group ms-auto"><a href="javascript" class="avatar avatar-xs me-2 rounded-circle" data-toggle="tooltip" data-original-title="Jessica Rowland"><img alt="Image placeholder" src="{{ asset('assets') }}/img/team-1.jpg" class=""></a><a href="javascript" class="avatar avatar-xs rounded-circle me-2" data-toggle="tooltip" data-original-title="Audrey Love"><img alt="Image placeholder" src="{{ asset('assets') }}/img/team-2.jpg" class="rounded-circle"></a><a href="javascript" class="avatar avatar-xs me-2 rounded-circle" data-toggle="tooltip" data-original-title="Michael Lewis"><img alt="Image placeholder" src="{{ asset('assets') }}/img/team-3.jpg" class="rounded-circle"></a></div></div>',
                  assignee: "Done Joe",
                  description: "This task's description is for something, but not for anything",
                  class: ["border-radius-xl"]
                },
              ]
            },
            {
              id: "_progress",
              title: "In progress",
              item: [{
                  id: "_task_3_title_id",
                  title: '<span class="badge badge-sm bg-gradient-warning">Errors</span><p class="text mt-2">Fix Firefox errors</p><div class="d-flex"><div> <i class="fa fa-paperclip me-1 text-sm"></i><span class="text-sm">11</span></div><div class="avatar-group ms-auto"><a href="javascript" class="avatar avatar-xs me-2 rounded-circle" data-toggle="tooltip" data-original-title="Jana Lucie"><img alt="Image placeholder" src="{{ asset('assets') }}/img/team-3.jpg" class=""></a><a href="javascript" class="avatar avatar-xs me-2 rounded-circle" data-toggle="tooltip" data-original-title="Jessica Rowland"><img alt="Image placeholder" src="{{ asset('assets') }}/img/team-2.jpg" class=""></a></div></div>',
                  class: ["border-radius-xl"]
                },
                {
                  id: "_task_4_title_id",
                  title: '<span class="badge badge-sm bg-gradient-info">Updates</span><p class="text mt-2">Argon Dashboard PRO - Angular 11</p><div class="d-flex"><div> <i class="fa fa-paperclip me-1 text-sm"></i><span class="text-sm">3</span></div><div class="avatar-group ms-auto"><a href="javascript" class="avatar avatar-xs me-2 rounded-circle" data-toggle="tooltip" data-original-title="Jana Lucie"><img alt="Image placeholder" src="{{ asset('assets') }}/img/team-5.jpg" class=""></a><a href="javascript" class="avatar avatar-xs me-2 rounded-circle" data-toggle="tooltip" data-original-title="Jessica Rowland"><img alt="Image placeholder" src="{{ asset('assets') }}/img/team-4.jpg" class=""></a></div></div>',
                  class: ["border-radius-xl"]
                },
                {
                  id: "_task_do_something_4_id",
                  title: '<img src="{{ asset('assets') }}/img/meeting.jpg" class="w-100"><span class="mt-3 badge badge-sm bg-gradient-info">Updates</span><p class="text mt-2">Vue 3 Updates</p><div class="d-flex"><div> <i class="fa fa-paperclip me-1 text-sm"></i><span class="text-sm">9</span></div><div class="avatar-group ms-auto"><a href="javascript" class="avatar avatar-xs me-2 rounded-circle" data-toggle="tooltip" data-original-title="Jessica Rowland"><img alt="Image placeholder" src="{{ asset('assets') }}/img/team-1.jpg" class=""></a><a href="javascript" class="avatar avatar-xs rounded-circle me-2" data-toggle="tooltip" data-original-title="Audrey Love"><img alt="Image placeholder" src="{{ asset('assets') }}/img/team-2.jpg" class="rounded-circle"></a><a href="javascript" class="avatar avatar-xs me-2 rounded-circle" data-toggle="tooltip" data-original-title="Michael Lewis"><img alt="Image placeholder" src="{{ asset('assets') }}/img/team-4.jpg" class="rounded-circle"></a></div></div>',
                  assignee: "Done Joe",
                  description: "This task's description is for something, but not for anything",
                  class: ["border-radius-xl"]
                }
              ]

            },
            {
              id: "_working",
              title: "In review",
              item: [{
                  id: "_task_do_something_2_id",
                  title: '<span class="badge badge-sm bg-gradient-warning">In Testing</span><p class="text mt-2">Responsive Changes</p><div class="d-flex"><div> <i class="fa fa-paperclip me-1 text-sm"></i><span class="text-sm">11</span></div><div class="avatar-group ms-auto"><a href="javascript" class="avatar avatar-xs me-2 rounded-circle" data-toggle="tooltip" data-original-title="Jana Lucie"><img alt="Image placeholder" src="{{ asset('assets') }}/img/team-3.jpg" class=""></a><a href="javascript" class="avatar avatar-xs me-2 rounded-circle" data-toggle="tooltip" data-original-title="Jessica Rowland"><img alt="Image placeholder" src="{{ asset('assets') }}/img/team-2.jpg" class=""></a></div></div>',
                  assignee: "Done Joe",
                  description: "This task's description is for something, but not for anything",
                  class: ["border-radius-xl"]
                },
                {
                  id: "_task_run_id",
                  title: '<span class="badge badge-sm bg-gradient-success">In review</span><p class="text mt-2 mb-1">Change images dimension</p><div class="col"><div class="progress progressm mb-3 w5"><div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;"></div></div></div><div class="d-flex"><div class="avatar-group ms-auto"><a href="javascript" class="avatar avatar-xs me-2 rounded-circle" data-toggle="tooltip" data-original-title="Jessica Rowland"><img alt="Image placeholder" src="{{ asset('assets') }}/img/team-3.jpg" class=""></a></div></div>',
                  assignee: "Done Joe",
                  description: "This task's description is for something, but not for anything",
                  class: ["border-radius-xl"]
                },
                {
                  id: "_task_do_something_3_id",
                  title: '<span class="badge badge-sm bg-gradient-info">In Review</span><p class="text mt-2 mb-1">Update Links</p><div class="col"><div class="progress progressm mb-3 w5"><div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div></div></div><div class="d-flex"><div> <i class="fa fa-paperclip me-1 text-sm"></i><span class="text-sm">6</span></div><div class="avatar-group ms-auto"><a href="javascript" class="avatar avatar-xs me-2 rounded-circle" data-toggle="tooltip" data-original-title="Jana Lucie"><img alt="Image placeholder" src="{{ asset('assets') }}/img/team-5.jpg" class=""></a><a href="javascript" class="avatar avatar-xs me-2 rounded-circle" data-toggle="tooltip" data-original-title="Mike Alis"><img alt="Image placeholder" src="{{ asset('assets') }}/img/team-1.jpg" class=""></a></div></div>',
                  assignee: "Done Joe",
                  description: "This task's description is for something, but not for anything",
                  class: ["border-radius-xl"]
                }
              ]
            },
            {
              id: "_done",
              title: "Done",
              item: [{
                  id: "_task_all_right_id",
                  title: '<img src="{{ asset('assets') }}/img/home-decor-1.jpg" class="w-100"><span class="mt-3 badge badge-sm bg-gradient-success">Done</span><p class="text mt-2">Redesign for the home page</p><div class="d-flex"><div> <i class="fa fa-paperclip me-1 text-sm"></i><span class="text-sm">8</span></div><div class="avatar-group ms-auto"><a href="javascript" class="avatar avatar-xs me-2 rounded-circle" data-toggle="tooltip" data-original-title="Jessica Rowland"><img alt="Image placeholder" src="{{ asset('assets') }}/img/team-5.jpg" class=""></a><a href="javascript" class="avatar avatar-xs rounded-circle me-2" data-toggle="tooltip" data-original-title="Audrey Love"><img alt="Image placeholder" src="{{ asset('assets') }}/img/team-1.jpg" class="rounded-circle"></a><a href="javascript" class="avatar avatar-xs me-2 rounded-circle" data-toggle="tooltip" data-original-title="Michael Lewis"><img alt="Image placeholder" src="{{ asset('assets') }}/img/team-4.jpg" class="rounded-circle"></a></div></div>',
                  assignee: "Done Joe",
                  description: "This task's description is for something, but not for anything",
                  class: ["border-radius-xl"]
                },
                {
                  id: "_task_ok_id",
                  title: '<span class="badge badge-sm bg-gradient-success">Done</span><p class="text mt-2">Schedule winter campaign</p><div class="d-flex"><div> <i class="fa fa-paperclip me-1 text-sm"></i><span class="text-sm">2</span></div><div class="avatar-group ms-auto"><a href="javascript" class="avatar avatar-xs me-2 rounded-circle" data-toggle="tooltip" data-original-title="Michael Laurence"><img alt="Image placeholder" src="{{ asset('assets') }}/img/team-1.jpg" class=""></a><a href="javascript" class="avatar avatar-xs me-2 rounded-circle" data-toggle="tooltip" data-original-title="Michael Lewis"><img alt="Image placeholder" src="{{ asset('assets') }}/img/team-4.jpg" class="rounded-circle"></a></div></div>',
                  assignee: "Done Joe",
                  description: "This task's description is for something, but not for anything",
                  class: ["border-radius-xl"]
                }
              ]
            }
          ]
        });

        var addBoardDefault = document.getElementById("jkanban-add-new-board");
        addBoardDefault.addEventListener("click", function() {
          let newBoardName = document.getElementById("jkanban-new-board-name")
            .value;
          let newBoardId = "_" + newBoardName.toLowerCase().replace(/ /g, "_");
          KanbanTest.addBoards([{
            id: newBoardId,
            title: newBoardName,
            item: []
          }]);
          document.querySelector('#new-board-modal').classList.remove('show');
          document.querySelector('body').classList.remove('modal-open');

          document.querySelector('.modal-backdrop').remove();
        });

        var updateTask = document.getElementById("jkanban-update-task");
        updateTask.addEventListener("click", function() {
          let jkanbanInfoModalTaskId = document.querySelector(
            "#jkanban-info-modal #jkanban-task-id"
          );
          let jkanbanInfoModalTaskTitle = document.querySelector(
            "#jkanban-info-modal #jkanban-task-title"
          );
          let jkanbanInfoModalTaskAssignee = document.querySelector(
            "#jkanban-info-modal #jkanban-task-assignee"
          );
          let jkanbanInfoModalTaskDescription = document.querySelector(
            "#jkanban-info-modal #jkanban-task-description"
          );
          KanbanTest.replaceElement(jkanbanInfoModalTaskId.value, {
            title: jkanbanInfoModalTaskTitle.value,
            assignee: jkanbanInfoModalTaskAssignee.value,
            description: jkanbanInfoModalTaskDescription.value
          });
          jkanbanInfoModalTaskId.value = jkanbanInfoModalTaskId.value;
          jkanbanInfoModalTaskTitle.value = jkanbanInfoModalTaskTitle.value;
          jkanbanInfoModalTaskAssignee.value = jkanbanInfoModalTaskAssignee.value;
          jkanbanInfoModalTaskDescription.value = jkanbanInfoModalTaskDescription.value;
          document.querySelector('#jkanban-info-modal').classList.remove('show');
          document.querySelector('body').classList.remove('modal-open');
          document.querySelector('.modal-backdrop').remove();


        });
      }
    })();
  </script>
@endpush
