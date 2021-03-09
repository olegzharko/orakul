import { ClientItem, ImmovableItem } from '../../../../../../../../types';

export type ImmovableItemKey = keyof ImmovableItem;

export const immovableItem: ImmovableItem = {
  contract_type_id: null,
  building_id: null,
  imm_type_id: null,
  imm_num: null,
  bank: false,
  proxy: false,
};

export const clientItem: ClientItem = {
  phone: null,
  full_name: null,
};
