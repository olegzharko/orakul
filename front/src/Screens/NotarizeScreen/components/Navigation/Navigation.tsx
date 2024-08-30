import * as React from 'react';
import { useHistory } from 'react-router-dom';
import ControlPanel from '../../../../components/ControlPanel';
import { NotarizeNavigationTypes } from '../../useNotarizeScreen';

type Props = {
  selected: NotarizeNavigationTypes;
  onSelect: (value: NotarizeNavigationTypes) => void;
}

const Navigation = ({ onSelect, selected }: Props) => {
  const history = useHistory();

  const handleClick = (type: NotarizeNavigationTypes) => {
    onSelect(type);
    history.push(`/${type}`);
  };

  return (
    <ControlPanel>
      {/* <button
        className={`navigation-button ${
          selected === NotarizeNavigationTypes.DEVELOPER ? 'selected' : ''
        }`}
        type="button"
        onClick={() => handleClick(NotarizeNavigationTypes.DEVELOPER)}
      >
        <img src="/images/navigation/developer.svg" alt="developer" />
        Забудовки
      </button>
      <button
        className={`navigation-button ${
          selected === NotarizeNavigationTypes.IMMOVABLE ? 'selected' : ''
        }`}
        type="button"
        onClick={() => handleClick(NotarizeNavigationTypes.IMMOVABLE)}
      >
        <img src="/images/navigation/immovable.svg" alt="immovable" />
        Нерухомсіть
      </button> */}
      <button
        className={`navigation-button ${
          selected === NotarizeNavigationTypes.POWER_OF_ATTORNEY ? 'selected' : ''
        }`}
        type="button"
        onClick={() => handleClick(NotarizeNavigationTypes.POWER_OF_ATTORNEY)}
      >
        <img src="/images/navigation/immovable.svg" alt="powerOfAttorney" />
        Довіреність
      </button>
    </ControlPanel>
  );
};

export default Navigation;
