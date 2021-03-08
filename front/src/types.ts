export type ImmovableItem = {
  contract_type_id: number | undefined;
  building_id: number | undefined;
  imm_type_id: number | undefined;
  imm_num: number | undefined;
  bank: boolean;
  proxy: boolean;
};

export type ImmovableItems = ImmovableItem[];

export type SelectItem = {
  id: number;
  title: string;
};

export type ClientItem = {
  phone: string;
  full_name: string;
};

export type NewCard = {
  immovables: ImmovableItems;
  clients: ClientItem[];
  date_time: string;
  dev_company_id: number | undefined;
  dev_representative_id: number | undefined;
  dev_manager_id: number | undefined;
  room_id: number;
  notary_id: number | undefined;
};
