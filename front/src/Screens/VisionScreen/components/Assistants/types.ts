export type AssistantsWorkspaceStaffProcess = {
  ready: number;
  total: number;
};

export type AssistantsWorkspaceStaff = {
  accompanying: AssistantsWorkspaceStaffProcess;
  color: string;
  full_name: string;
  generate: AssistantsWorkspaceStaffProcess;
  read: AssistantsWorkspaceStaffProcess;
  time: string;
}

export type AssistantsWorkspace = {
  title: string;
  staff: AssistantsWorkspaceStaff[];
};
