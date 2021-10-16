import React from 'react';
import { Switch, Route } from 'react-router';
import { Link } from 'react-router-dom';

import ContentPanel from '../../../../components/ContentPanel';
import ControlPanel from '../../../../components/ControlPanel';
import Loader from '../../../../components/Loader/Loader';
import routes from '../../../../routes';

import ContractChecklist from './components/ContractChecklist';
import ContractMainDashboard from './components/ContractMainDashboard';

import { useContractsDashboard } from './useContractsDashboard';

const LineItemProcess = () => {
  const {
    isLoading,
    formattedCards,
    processType,
    lineItemId,
  } = useContractsDashboard();

  if (isLoading) return <Loader />;

  return (
    <main className="manage df">
      <ControlPanel>
        <Link to={routes.factory.processLineItem.linkTo(processType, lineItemId)} className="navigation-button selected">
          <img src="/images/navigation/book-open.svg" alt="main" />
          Головна
        </Link>
      </ControlPanel>

      <ContentPanel>
        <Switch>
          <Route {...routes.factory.processLineItem.checkList}>
            <ContractChecklist />
          </Route>

          <Route {...routes.factory.processLineItem}>
            <ContractMainDashboard cards={formattedCards} title="Нерухомість" />
          </Route>
        </Switch>
      </ContentPanel>
    </main>
  );
};

export default LineItemProcess;
