import getCardsByContractType from '../../../../services/generator/getCardsByContractType';
import getAppointments from '../../../../services/getAppointments';
import { UserTypes } from '../../../../types';
import { MANAGE_CONTAINER_LINK_PREFIX } from '../../constants';
import { DashboardAssistantInfoNavigationLinks } from '../../enums';

import { formatClientsCards } from './utils';

export const loadClientCards = async (token: string, history: any) => {
  const res = await getAppointments(token, UserTypes.GENERATOR);

  if (res?.success) {
    return [
      formatClientsCards(res.data.accompanying, history, `${MANAGE_CONTAINER_LINK_PREFIX}/main`),
      formatClientsCards(res.data.generator, history, `${DashboardAssistantInfoNavigationLinks.issuance}/check-list`),
      formatClientsCards(res.data.reader, history, `${DashboardAssistantInfoNavigationLinks.reading}/check-list`),
    ];
  }

  return [];
};

export const loadClientsCardsByContract = async (token: string, url: string, history: any) => {
  const res = await getCardsByContractType(token, url);

  if (res?.success) {
    return [
      formatClientsCards(res.data.accompanying, history, `${MANAGE_CONTAINER_LINK_PREFIX}/main`),
      formatClientsCards(res.data.generator, history, `${DashboardAssistantInfoNavigationLinks.issuance}/check-list`),
      formatClientsCards(res.data.reader, history, `${DashboardAssistantInfoNavigationLinks.reading}/check-list`),
    ];
  }

  return [];
};
