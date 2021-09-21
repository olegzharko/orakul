import React from 'react';
import { Route, Switch, useHistory } from 'react-router-dom';

import CheckList from '../../../../../../components/CheckList';
import Dashboard from '../../../../../../components/Dashboard';
import { DashboardAssistantInfoNavigationLinks } from '../../../../enums';

import { dashboardData } from '../../config';

const DashboardAssistantInfoIssuancePage = () => {
  const history = useHistory();

  return (
    <div className="df">
      <Switch>
        <Route path={DashboardAssistantInfoNavigationLinks.issuance} exact>
          <Dashboard
            isChangeTypeButton
            sections={dashboardData.map((d) => ({
              ...d,
              cards: d.cards.map((c) => ({
                ...c,
                onClick: () => {
                  history.push(`${DashboardAssistantInfoNavigationLinks.issuance}/${c.id}/check-list`);
                },
              })),
            }))}
          />
        </Route>

        <Route path={`${DashboardAssistantInfoNavigationLinks.issuance}/:cardId/check-list`}>
          <div className="flex-center">
            <CheckList />
          </div>
        </Route>
      </Switch>
    </div>
  );
};

export default DashboardAssistantInfoIssuancePage;