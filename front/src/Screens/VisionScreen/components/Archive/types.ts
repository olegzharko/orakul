export type ArchiveToolsNotary = {
  id: number;
  title: string;
};

export type ArchiveToolsNotaryFormatted = {
  id: number;
  title: string;
  onClick: () => void;
}

export type ArchiveSelectsFilterData = {
  contract_type_id?: string;
  dev_company_id?: string;
  dev_representative_id?: string;
}

export type ArchivePeriod = {
  start_date?: Date;
  final_date?: Date;
}

export type ArchiveToolsTableHeader = {
  alias: string;
  title: string
}
