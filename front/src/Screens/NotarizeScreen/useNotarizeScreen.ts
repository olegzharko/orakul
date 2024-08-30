import { useEffect, useMemo, useState, useCallback } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { useHistory } from 'react-router';

import { SectionCard } from '../../components/Dashboard/components/DashboardSection/DashboardSection';
import { fetchImmovables, fetchDevelopers, fetchPowerOfAttorneys } from '../../store/notarize/actions';
import { State } from '../../store/types';

/* eslint-disable no-shadow */
export enum NotarizeNavigationTypes {
  DEVELOPER = 'developer',
  IMMOVABLE = 'immovable',
  POWER_OF_ATTORNEY = 'power-of-attorney',
}

export const useNotarizeScreen = () => {
  const dispatch = useDispatch();
  const history = useHistory();

  const {
    isLoading, developers, immovables, powerOfAttorneys
  } = useSelector((state: State) => state.notarize);
  const [selectedNav, setSelectedNav] = useState(NotarizeNavigationTypes.DEVELOPER);
  const [selectedId, setSelectedId] = useState<any>();
  const [trigger, setTrigger] = useState(true);

  const onChangeNav = useCallback((id, type) => {
    setSelectedId(id);
    setSelectedNav(type);
  }, []);

  const triggerNav = useCallback((val) => {
    setSelectedNav(val);
    setTrigger((prev) => !prev);
  }, []);

  const selectedCardData = useMemo(() => {
    if (selectedNav === NotarizeNavigationTypes.IMMOVABLE) {
      return immovables ? immovables.immovables
        .find((item: any) => item.id === Number(selectedId)) : null;
    }

    if (selectedNav === NotarizeNavigationTypes.POWER_OF_ATTORNEY) {
      return powerOfAttorneys ? powerOfAttorneys.powerOfAttorneys
        .find((item: any) => item.id === Number(selectedId)) : null;
    }

    return developers ? developers.developers
      .find((item: any) => item.id === Number(selectedId)) : null;
  }, [selectedNav, developers, immovables, powerOfAttorneys, selectedId]);

  const sections = useMemo(() => {
    let title = '';
    let cards: SectionCard[] = [];

    if (selectedNav === NotarizeNavigationTypes.DEVELOPER) {
      title = developers?.date_info || '';
      cards = (developers?.developers || []).map((item: any) => ({
        id: item.id,
        title: item.title,
        content: [`Дата: ${item.date}`, `Номер: ${item.number}`],
        color: item.color,
        onClick: () => {
          history.push(`/${selectedNav}/${item.id}`);
        }
      }));
    } else if (selectedNav === NotarizeNavigationTypes.IMMOVABLE) {
      title = immovables?.date_info || '';
      cards = (immovables?.immovables || []).map((item: any) => ({
        id: item.id,
        title: item.title,
        content: [`Дата: ${item.date}`, `Номер: ${item.number}`],
        color: item.color,
        onClick: () => {
          history.push(`/${selectedNav}/${item.id}`);
        }
      }));
    } else if (selectedNav === NotarizeNavigationTypes.POWER_OF_ATTORNEY) {
      title = powerOfAttorneys?.date_info || '';
      cards = (powerOfAttorneys?.powerOfAttorneys || []).map((item: any) => ({
        id: item.id,
        title: item.title,
        content: [`Дата: ${item.date}`, `Номер: ${item.number}`],
        color: item.color,
        onClick: () => {
          history.push(`/${selectedNav}/${item.id}`);
        }
      }));
    }

    return [{
      title,
      cards,
    }];
  }, [
    developers?.date_info,
    developers?.developers,
    immovables?.date_info,
    immovables?.immovables,
    powerOfAttorneys?.date_info,
    powerOfAttorneys?.powerOfAttorneys,
    selectedNav,
    history
  ]);

  useEffect(() => {
    if (selectedNav === NotarizeNavigationTypes.DEVELOPER) {
      dispatch(fetchDevelopers());
    } else if (selectedNav === NotarizeNavigationTypes.IMMOVABLE) {
      dispatch(fetchImmovables());
    } else if (selectedNav === NotarizeNavigationTypes.POWER_OF_ATTORNEY) {
      dispatch(fetchPowerOfAttorneys());
    }
  }, [trigger, selectedId, selectedNav, dispatch]);

  return {
    selectedNav,
    isLoading,
    sections,
    selectedCardData,
    triggerNav,
    onChangeNav,
  };
};
