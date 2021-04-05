import * as React from 'react';
import ControlPanel from '../../../../../../components/ControlPanel';
import { DashboardContractNavigation } from '../../../../useDashboardScreen';
import { useNavigation } from './useNavigation';

type Props = {
  selected?: DashboardContractNavigation;
}

const Navigation = ({ selected }: Props) => {
  const meta = useNavigation();

  return (
    <ControlPanel>
      <button
        className={`navigation-button ${
          selected === DashboardContractNavigation.MAIN ? 'selected' : ''
        }`}
        type="button"
        onClick={() => meta.handleClick(DashboardContractNavigation.MAIN)}
      >
        <img src="/icons/navigation/book-open.svg" alt="main" />
        Головна
      </button>

      {meta.shouldShowSeller && (
        <button
          className={`navigation-button ${
            selected === DashboardContractNavigation.SELLER ? 'selected' : ''
          }`}
          type="button"
          onClick={() => meta.handleClick(DashboardContractNavigation.SELLER)}
        >
          <img src="/icons/navigation/developer.svg" alt="seller" />
          Продавець
        </button>
      )}

      {meta.shouldShowImmovable && (
        <button
          className={`navigation-button ${
            selected === DashboardContractNavigation.IMMOVABLES ? 'selected' : ''
          }`}
          type="button"
          onClick={() => meta.handleClick(DashboardContractNavigation.IMMOVABLES)}
        >
          <img src="/icons/navigation/immovable.svg" alt="immovables" />
          Нерухомість
        </button>
      )}

      {meta.shouldShowClient && (
        <button
          className={`navigation-button ${
            selected === DashboardContractNavigation.CLIENTS ? 'selected' : ''
          }`}
          type="button"
          onClick={() => meta.handleClick(DashboardContractNavigation.CLIENTS)}
        >
          <img src="/icons/navigation/user.svg" alt="clients" />
          Клієнти
        </button>
      )}

      {meta.shouldShowSideNotaries && (
        <button
          className={`navigation-button ${
            selected === DashboardContractNavigation.SIDE_NOTARIES ? 'selected' : ''
          }`}
          type="button"
          onClick={() => meta.handleClick(DashboardContractNavigation.SIDE_NOTARIES)}
        >
          <img src="/icons/navigation/book-open.svg" alt="side notaries" />
          Сторонній нотаріус
        </button>
      )}
    </ControlPanel>
  );
};

export default Navigation;
