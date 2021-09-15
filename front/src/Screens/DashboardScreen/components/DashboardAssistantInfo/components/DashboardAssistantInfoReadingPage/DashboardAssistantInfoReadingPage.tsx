import React from 'react';
import { Route, Switch, useHistory } from 'react-router';

import CheckList from '../../../../../../components/CheckList';
import Dashboard from '../../../../../../components/Dashboard';
import { DashboardAssistantInfoNavigationLinks } from '../../../../enums';

import Filter from '../../../DashboardContainer/components/FilterContainer';

import { dashboardData } from '../../config';

const DashboardAssistantInfoReadingPage = () => {
  const history = useHistory();

  return (
    <div className="df">
      <Switch>
        <Route path={DashboardAssistantInfoNavigationLinks.reading} exact>
          <Dashboard
            isChangeTypeButton
            sections={dashboardData.map((d) => ({
              ...d,
              cards: d.cards.map((c) => ({
                ...c,
                onClick: () => {
                  history.push(`${DashboardAssistantInfoNavigationLinks.reading}/${c.id}/check-list`);
                },
              })),
            }))}
          />
        </Route>

        <Route path={`${DashboardAssistantInfoNavigationLinks.reading}/:cardId/check-list`}>
          <div className="flex-center">
            <CheckList />
          </div>
        </Route>
      </Switch>
    </div>
  );
};

export default DashboardAssistantInfoReadingPage;
