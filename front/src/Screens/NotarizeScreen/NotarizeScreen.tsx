import * as React from 'react';
import { Switch, Route } from 'react-router-dom';
import './index.scss';
import Header from '../../components/Header';
import Navigation from './components/Navigation';
import { useNotarizeScreen } from './useNotarizeScreen';
import Loader from '../../components/Loader/Loader';
import ContentPanel from '../../components/ContentPanel';
import Dashboard from '../../components/Dashboard';
import Immovable from './components/Immovable';
import PowerOfAttorney from './components/PowerOfAttorney';
import Developer from './components/Developer';
import Modal from '../../components/RequestModal';
import { useRequestModal } from '../../components/RequestModal/useRequestModal';
import PowerOfAttorneyForm from './components/PowerOfAttorney/powerOfAttorneyForm/PowerOfAttorneyForm';

const NotarizeScreen = () => {
  const meta = useNotarizeScreen();
  const modalProps = useRequestModal();

  return (
    <>
      <Header />
      <main className="registrator">
        {/* это боковое меню раздела */}
        <Navigation onSelect={meta.triggerNav} selected={meta.selectedNav} />
        <ContentPanel>
          <Switch>
            {/* <Route path="/developer/:id" exact>
              <Developer onPathChange={meta.onChangeNav} developer={meta.selectedCardData} />
            </Route>

            <Route path="/immovable/:id" exact>
              <Immovable onPathChange={meta.onChangeNav} immovable={meta.selectedCardData} />
            </Route> */}

            <Route path="/power-of-attorney/:id" exact>
              <PowerOfAttorney
                onPathChange={meta.onChangeNav}
                powerOfAttorney={meta.selectedCardData}
              />
            </Route>
            {/* <Route path="/power-of-attorney/:id" exact>
              <PowerOfAttorneyForm />
            </Route> */}
            {/* loader покрывает только часть где карточки */}
            {meta.isLoading && <Loader />}
            {/* в Dashboard находятся карточки раздела */}
            {!meta.isLoading && <Dashboard sections={meta.sections} haveStatus />}
          </Switch>
        </ContentPanel>
      </main>
      <Modal {...modalProps} />
    </>
  );
};

export default NotarizeScreen;
