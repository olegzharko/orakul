import React from 'react';
import CustomSelect from '../../../../../../../../components/CustomSelect';
import { useFilter } from './useFilter';
import Loader from '../../../../../../../../components/Loader/Loader';

const Filter = () => {
  const meta = useFilter();

  if (!meta.shouldRenderFilter) {
    return null;
  }

  return (
    <div className="filter">
      <span style={{ whiteSpace: 'nowrap' }}>Сортувати по:</span>
      <div className="mh6 filter__select" style={{ width: '115px' }}>
        <CustomSelect
          data={meta.notaries}
          selectedValue={meta.selectedNotary}
          onChange={meta.setSelectedNotary}
          label="Нотаріус"
          size="small"
        />
      </div>

      <div className="mh6 filter__select" style={{ width: '90px' }}>
        <CustomSelect
          data={meta.readers}
          selectedValue={meta.selectedReader}
          onChange={meta.setSelectedReader}
          label="Читач"
          size="small"
        />
      </div>

      <div className="mh6 filter__select" style={{ width: '110px' }}>
        <CustomSelect
          data={meta.accompanyings}
          selectedValue={meta.selectedAccompanying}
          onChange={meta.setSelectedAccompanying}
          label="Видавач"
          size="small"
        />
      </div>

      <div className="mh6 filter__select" style={{ width: '150px' }}>
        <CustomSelect
          data={[]}
          selectedValue={meta.selectedContractType}
          onChange={meta.setSelectedContractType}
          label="Тип договору"
          size="small"
        />
      </div>

      <div className="mh6 filter__select" style={{ width: '140px' }}>
        <CustomSelect
          data={meta.developers}
          selectedValue={meta.selectedDeveloper}
          onChange={meta.setSelectedDeveloper}
          label="Забудовник"
          size="small"
        />
      </div>

      <div className="mh6 filter__select" style={{ width: '125px' }}>
        <CustomSelect
          data={meta.representative}
          selectedValue={meta.selectedRepresentative}
          onChange={meta.setSelectedRepresentative}
          label="Підписант"
          size="small"
        />
      </div>

      <div className="mh6 df">
        <img
          src="/icons/clear-form.svg"
          alt="clear form"
          onClick={meta.clearAll}
          className="filter__clear"
        />
      </div>
    </div>
  );
};

export default Filter;
