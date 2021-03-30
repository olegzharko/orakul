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

const RegistratorScreen = () => {
  const meta = useRegistratorScreen();

  return (
    <>
      <Header />
      <main className="registrator">
        <Navigation onSelect={meta.setSelectedNav} selected={meta.selectedNav} />
        <ContentPanel>
          <Switch>
            <Route path="/immovable/:id">
              <Immovable onImmovableChange={meta.setSelectedId} data={meta.selectedCardData} />
            </Route>

            <Route path="/developer/:id">
              <Developer onImmovableChange={meta.setSelectedId} data={meta.selectedCardData} />
            </Route>

            {meta.isLoading && <Loader />}
            {!meta.isLoading
              && <Dashboard link={meta.selectedNav} sections={meta.sections} />}
          </Switch>
        </ContentPanel>
      </main>
    </>
  );
};

export default RegistratorScreen;
