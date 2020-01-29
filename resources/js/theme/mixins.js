import { css } from 'styled-components';
import breakpoints from './breakpoints';
import { grey } from './palette';

const getMin = key => `@media screen and (min-width: ${breakpoints[key]}px)`;

const getMinLandscape = key => `@media screen and (min-width: ${breakpoints[key]}px) and (orientation: landscape)`;

const getMinCustom = size => `@media screen and (min-width: ${size}px)`;

export const devices = {
  mobileXs: getMin('viewport320'),
  mobileXsLandscape: getMinLandscape('viewport320'),
  mobile: getMin('viewport360'),
  mobileLandscape: getMinLandscape('viewport480'),
  tablet: getMin('viewport768'),
  tabletLandscape: getMin('viewport992'),
  laptop: getMin('viewport1024'),
  desktop: getMin('viewport1280')
};

export const flexCenter = css`
  display: flex;
  align-items: center;
  justify-content: center;
`;

export const absoluteCenter = css`
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  margin: auto;
`;

export const removeButtonStyle = css`
  appearance: none;
  padding: 0;
  border: 0;
  outline: 0;
  background-color: transparent;
`;

export const removeAutocomplete = css`
  &:-webkit-autofill {
    -webkit-box-shadow: 0 0 0 30px white inset;
    box-shadow: 0 0 0 30px white inset;
  }
`;

export const removeInputOutline = css`
  &:active,
  &:focus {
    outline: none;
  }
`;

export const removeAfterBefore = css`
  &:before,
  &:after {
    content: normal;
  }
`;

export const responsive = {
  mobileXs: (...args) => css`
    ${devices.mobileXs} {
      ${css(...args)}
    }
  `,
  mobileXsLandscape: (...args) => css`
    ${devices.mobileXsLandscape} {
      ${css(...args)}
    }
  `,
  mobile: (...args) => css`
    ${devices.mobile} {
      ${css(...args)}
    }
  `,
  mobileLandscape: (...args) => css`
    ${devices.mobileLandscape} {
      ${css(...args)}
    }
  `,
  tablet: (...args) => css`
    ${devices.tablet} {
      ${css(...args)}
    }
  `,
  tabletLandscape: (...args) => css`
    ${devices.tabletLandscape} {
      ${css(...args)}
    }
  `,
  laptop: (...args) => css`
    ${devices.laptop} {
      ${css(...args)}
    }
  `,
  desktop: (...args) => css`
    ${devices.desktop} {
      ${css(...args)}
    }
  `,
  custom: (size, ...styles) => css`
    ${getMinCustom(size)} {
      ${css(...styles)}
    }`
};

export const backgroundImg = url => css`
  background-image: url(${url});
  background-size: cover;
  background-position: center;
`;

export const scrollbar = css`
  &::-webkit-scrollbar {
    width: 9px;
  }
  &::-webkit-scrollbar-track {
    background-color: ${grey.grey3};
  }
  &::-webkit-scrollbar-thumb {
    background-color: ${grey.grey6};
  }
  scrollbar-color: ${grey.grey6} ${grey.grey3};
  scrollbar-width: 9px;
`;
