export const valueUpdater = (updaterOrValue, ref) => {
    ref.value = typeof updaterOrValue === 'function'
        ? updaterOrValue(ref.value)
        : updaterOrValue
}
