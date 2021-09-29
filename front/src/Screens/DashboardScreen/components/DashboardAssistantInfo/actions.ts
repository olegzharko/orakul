import getCardsByContractType from '../../../../services/generator/getCardsByContractType';
import getAppointments from '../../../../services/getAppointments';
import { FilterData } from '../../../../store/types';
import { UserTypes } from '../../../../types';
import postAppointmentsByFilter from '../../../../services/postAppointmentsByFilter';

import { formatAssistantData, formatNavigationValues } from './utils';

export const loadClientCards = async (token: string, history: any, userType: UserTypes) => {
  const res = await getAppointments(token, userType);

  if (res?.success) {
    return [
      ...formatAssistantData(res.data, history, userType),
      formatNavigationValues(res.data.info),
    ];
  }

  return [];
};

export const loadClientsCardsByContract = async (
  token: string,
  url: string,
  history: any,
  userType: UserTypes,
) => {
  const res = await getCardsByContractType(token, url);

  if (res?.success) {
    return [
      ...formatAssistantData(res.data, history, userType),
      formatNavigationValues(res.data.info),
    ];
  }

  return [];
};

export const onFiltersChangeAction = async (
  token: string,
  bodyData: FilterData,
  user_type: UserTypes,
  history: any,
) => {
  const res = await postAppointmentsByFilter(token, { ...bodyData, user_type });

  if (res?.success) {
    return [
      ...formatAssistantData(res.data, history, user_type),
      formatNavigationValues(res.data.info),
    ];
  }

  return [];
};
