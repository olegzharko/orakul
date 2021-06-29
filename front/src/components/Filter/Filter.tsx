import React from 'react';
import './index.scss';
import CustomSelect from '../CustomSelect';
import { useFilter, Props } from './useFilter';

const Filter = (props: Props) => {
  const meta = useFilter(props);

  if (!meta.shouldRenderFilter) {
    return null;
  }

  return (
    <div className={`filter ${props.horizontal ? 'horizontal' : ''}`}>
      {!props.horizontal && (
        <div className="filter__header">
          <span className="title">Фільтр</span>
          <img
            src="/images/clear-form.svg"
            alt="clear form"
            onClick={meta.clearAll}
            className="filter__clear"
          />
        </div>
      )}
      <div className="filter__select" style={{ width: props.horizontal ? '115px' : '100%' }}>
        <CustomSelect
          data={meta.notaries}
          selectedValue={meta.selectedNotary}
          onChange={meta.setSelectedNotary}
          label="Нотаріус"
          size={props.horizontal ? 'small' : 'medium'}
        />
      </div>

      <div className="filter__select" style={{ width: props.horizontal ? '90px' : '100%' }}>
        <CustomSelect
          data={meta.readers}
          selectedValue={meta.selectedReader}
          onChange={meta.setSelectedReader}
          label="Читач"
          size={props.horizontal ? 'small' : 'medium'}
        />
      </div>

      <div className="filter__select" style={{ width: props.horizontal ? '110px' : '100%' }}>
        <CustomSelect
          data={meta.accompanyings}
          selectedValue={meta.selectedAccompanying}
          onChange={meta.setSelectedAccompanying}
          label="Видавач"
          size={props.horizontal ? 'small' : 'medium'}
        />
      </div>

      <div className="filter__select" style={{ width: props.horizontal ? '150px' : '100%' }}>
        <CustomSelect
          data={meta.contractTypes}
          selectedValue={meta.selectedContractType}
          onChange={meta.setSelectedContractType}
          label="Тип договору"
          size={props.horizontal ? 'small' : 'medium'}
        />
      </div>

      <div className="filter__select" style={{ width: props.horizontal ? '140px' : '100%' }}>
        <CustomSelect
          data={meta.developers}
          selectedValue={meta.selectedDeveloper}
          onChange={meta.setSelectedDeveloper}
          label="Забудовник"
          size={props.horizontal ? 'small' : 'medium'}
        />
      </div>

      <div className="filter__select" style={{ width: props.horizontal ? '125px' : '100%' }}>
        <CustomSelect
          data={meta.representative}
          selectedValue={meta.selectedRepresentative}
          onChange={meta.setSelectedRepresentative}
          label="Підписант"
          size={props.horizontal ? 'small' : 'medium'}
        />
      </div>

      {!props.horizontal && (
        <div
          className="filter__select"
        >
          <CustomSelect
            data={meta.sortType}
            selectedValue={meta.selectedSortType}
            onChange={meta.setSelectedSortType}
            label="Сортувати"
            size="medium"
          />
        </div>
      )}

      {props.horizontal && (
        <div className=" df">
          <img
            src="/images/clear-form.svg"
            alt="clear form"
            onClick={meta.clearAll}
            className="filter__clear"
          />
        </div>
      )}
    </div>
  );
};

export default Filter;
