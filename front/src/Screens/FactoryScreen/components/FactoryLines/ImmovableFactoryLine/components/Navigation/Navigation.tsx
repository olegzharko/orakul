import * as React from 'react';

import ControlPanel from '../../../../../../../components/ControlPanel';
import routes, { ImmovableFactoryLineSections } from '../../../../../../../routes';

import { useNavigation } from './useNavigation';

type Props = {
  selected?: ImmovableFactoryLineSections;
}

const Navigation = ({ selected }: Props) => {
  const meta = useNavigation();

  return (
    <ControlPanel>
      <button
        className={`navigation-button ${
          selected === ImmovableFactoryLineSections.main ? 'selected' : ''
        }`}
        type="button"
        onClick={() => meta.handleClick(routes.factory.lines.immovable.sections.main.base)}
      >
        <img src="/images/navigation/book-open.svg" alt="main" />
        Головна
      </button>

      {meta.shouldShowSeller && (
        <button
          className={`navigation-button ${
            selected === ImmovableFactoryLineSections.seller ? 'selected' : ''
          }`}
          type="button"
          onClick={() => meta.handleClick(routes.factory.lines.immovable.sections.seller.base)}
        >
          <img src="/images/navigation/developer.svg" alt="seller" />
          Продавець
        </button>
      )}

      {meta.shouldShowImmovable && (
        <button
          className={`navigation-button ${
            selected === ImmovableFactoryLineSections.immovables ? 'selected' : ''
          }`}
          type="button"
          onClick={() => meta.handleClick(routes.factory.lines.immovable.sections.immovables.base)}
        >
          <img src="/images/navigation/immovable.svg" alt="immovables" />
          Нерухомість
        </button>
      )}

      {meta.shouldShowClient && (
        <button
          className={`navigation-button ${
            selected === ImmovableFactoryLineSections.clients ? 'selected' : ''
          }`}
          type="button"
          onClick={() => meta.handleClick(routes.factory.lines.immovable.sections.clients.base)}
        >
          <img src="/images/navigation/user.svg" alt="clients" />
          Клієнти
        </button>
      )}

      {meta.shouldShowSideNotaries && (
        <button
          className={`navigation-button ${
            selected === ImmovableFactoryLineSections.sideNotaries ? 'selected' : ''
          }`}
          type="button"
          onClick={
            () => meta.handleClick(routes.factory.lines.immovable.sections.sideNotaries.base)
          }
        >
          <img src="/images/navigation/book-open.svg" alt="side notaries" />
          Сторонній нотаріус
        </button>
      )}
    </ControlPanel>
  );
};

export default Navigation;
