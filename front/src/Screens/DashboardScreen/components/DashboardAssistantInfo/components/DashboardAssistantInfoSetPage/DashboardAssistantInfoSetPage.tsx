import React from 'react';
import { useHistory } from 'react-router';

import Dashboard from '../../../../../../components/Dashboard';
import { MANAGE_CONTAINER_LINK_PREFIX } from '../../../../constants';

import Filter from '../../../DashboardContainer/components/FilterContainer';

import { dashboardData } from '../../config';

const DashboardAssistantInfoSetPage = () => {
  const history = useHistory();

  return (
    <Dashboard
      isChangeTypeButton
      sections={dashboardData.map((d) => ({
        ...d,
        cards: d.cards.map((c) => ({
          ...c,
          onClick: () => {
            history.push(`${MANAGE_CONTAINER_LINK_PREFIX}/main/${c.id}`);
          },
        })),
      }))}
    />
  );
};

export default DashboardAssistantInfoSetPage;
