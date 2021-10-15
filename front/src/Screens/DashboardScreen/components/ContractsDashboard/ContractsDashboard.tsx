import React from 'react';
import { Switch, Route } from 'react-router';
import { Link } from 'react-router-dom';
import ContentPanel from '../../../../components/ContentPanel';
import ControlPanel from '../../../../components/ControlPanel';

import Loader from '../../../../components/Loader/Loader';

import { MANAGE_PROCESS_LINK_PREFIX } from '../../constants';

import ContractChecklist from './components/ContractChecklist';
import ContractMainDashboard from './components/ContractMainDashboard';

import { useContractsDashboard } from './useContractsDashboard';

const ContractsDashboard = () => {
  const {
    isLoading,
    formattedCards,
    process,
    cardId,
  } = useContractsDashboard();

  if (isLoading) return <Loader />;

  return (
    <main className="manage df">
      <ControlPanel>
        <Link to={`${MANAGE_PROCESS_LINK_PREFIX}/${process}/${cardId}`} className="navigation-button selected">
          <img src="/images/navigation/book-open.svg" alt="main" />
          Головна
        </Link>
      </ControlPanel>

      <ContentPanel>
        <Switch>
          <Route path={`${MANAGE_PROCESS_LINK_PREFIX}/:process/:cardId`} exact>
            <ContractMainDashboard cards={formattedCards} title="Нерухомість" />
          </Route>

          <Route path={`${MANAGE_PROCESS_LINK_PREFIX}/:process/:cardId/checklist/:contractId`} exact>
            <ContractChecklist />
          </Route>
        </Switch>
      </ContentPanel>
    </main>
  );
};

export default ContractsDashboard;
