import * as React from 'react';
import { Switch, Route } from 'react-router-dom';
import './index.scss';
import Header from '../../components/Header';
import Navigation from './components/Navigation';
import { useRegistratorScreen } from './useRegistratorScreen';
import Loader from '../../components/Loader/Loader';
import ContentPanel from '../../components/ContentPanel';
import Dashboard from '../../components/Dashboard';
import Immovable from './components/Immovable';
import Developer from './components/Developer';
import Modal from '../../components/Modal';
import { useModal } from '../../components/Modal/useModal';

const RegistratorScreen = () => {
  const meta = useRegistratorScreen();
  const modalProps = useModal();

  return (
    <>
      <Header />
      <main className="registrator">
        <Navigation onSelect={meta.setSelectedNav} selected={meta.selectedNav} />
        <ContentPanel>
          <Switch>
            <Route path="/developer/:id" exact>
              <Developer onPathChange={meta.onChangeNav} developer={meta.selectedCardData} />
            </Route>

            <Route path="/immovable/:id" exact>
              <Immovable onPathChange={meta.onChangeNav} immovable={meta.selectedCardData} />
            </Route>

            {meta.isLoading && <Loader />}
            {!meta.isLoading
              && <Dashboard link={meta.selectedNav} sections={meta.sections} />}
          </Switch>
        </ContentPanel>
      </main>
      <Modal {...modalProps} />
    </>
  );
};

export default RegistratorScreen;
