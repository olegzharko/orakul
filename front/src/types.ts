export type ImmovableItem = {
  contract_type_id: number | null;
  building_id: number | null;
  imm_type_id: number | null;
  imm_num: number | null;
  bank: boolean;
  proxy: boolean;
};

export type ImmovableItems = ImmovableItem[];

export type SelectItem = {
  id: number;
  title: string;
};

export type ClientItem = {
  phone: string | null;
  full_name: string | null;
};

export type NewCard = {
  immovables: ImmovableItems;
  clients: ClientItem[];
  date_time: string;
  dev_company_id: number | null;
  dev_representative_id: number | null;
  dev_manager_id: number | null;
  room_id: number;
  notary_id: number | null;
};
